<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Session;
use Storage;
class SettingsController extends Controller
{
    protected function user()
    {
        $user = User::find(userAuthInfo()->id);
        $user['name'] = $user->firstname . ' ' . $user->lastname;
        return $user;
    }

    public function index()
    {
        return view('frontend.user.settings.index', ['user' => $this->user()]);
    }

    public function detailsUpdate(Request $request)
    {
        if($request->file('watermark')){
            $userFolder = "app/public/" . "/uploads/users/" . hashid(userAuthInfo()->id) . "/";
            $file = $request->file('watermark');    
            $mimeType = $file->getMimeType();
            if (strpos($mimeType, 'image') === 0) {
                $file->move(storage_path($userFolder), 'watermark.jpg');
            } else{
                toastr()->error('Please select an image');
                return back();
            }
            

        }

        $validator = Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:50'],
            'lastname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $this->user()->id],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $verify = (settings('website_email_verify_status') && $this->user()->email != $request->email) ? 1 : 0;
        $user = User::find($this->user()->id);
        if ($request->has('avatar')) {
            if ($this->user()->avatar == 'images/avatars/default.png') {
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', '110x110');
            } else {
                $uploadAvatar = vImageUpload($request->file('avatar'), 'images/avatars/users/', '110x110', null, $this->user()->avatar);
            }
        } else {
            $uploadAvatar = $this->user()->avatar;
        }
        if ($uploadAvatar) {
            $updateUser = $user->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'avatar' => $uploadAvatar,
            ]);
            if ($updateUser) {
                if ($verify) {
                    $user->forceFill(['email_verified_at' => null])->save();
                    $user->sendEmailVerificationNotification();
                    Session::put('email_change', true);
                }
                toastr()->success(lang('Account details has been updated successfully', 'alerts'));
                return back();
            }
        }
        
        
        
        
    }

    public function password()
    {
        return view('frontend.user.settings.password', ['user' => $this->user()]);
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current-password' => ['required'],
            'new-password' => ['required', 'string', 'min:8', 'confirmed'],
            'new-password_confirmation' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!(Hash::check($request->get('current-password'), $this->user()->password))) {
            toastr()->error(lang('Your current password does not matches with the password you provided', 'alerts'));
            return back();
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            toastr()->error(lang('New Password cannot be same as your current password. Please choose a different password', 'alerts'));
            return back();
        }
        $update = User::where('id', $this->user()->id)->update([
            'password' => bcrypt($request->get('new-password')),
        ]);
        if ($update) {
            toastr()->success(lang('Account password has been changed successfully', 'alerts'));
            return back();
        }
    }

    public function towFactor()
    {
        $QR_Image = null;
        if (!$this->user()->google2fa_status) {
            $google2fa = app('pragmarx.google2fa');
            $secretKey = encrypt($google2fa->generateSecretKey());
            User::where('id', $this->user()->id)->update(['google2fa_secret' => $secretKey]);
            $QR_Image = $google2fa->getQRCodeInline(settings('website_name'), $this->user()->email, $this->user()->google2fa_secret);
        }
        return view('frontend.user.settings.2fa', ['user' => $this->user(), 'QR_Image' => $QR_Image]);
    }

    public function towFactorEnable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($this->user()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(lang('Invalid OTP code', 'alerts'));
            return back();
        }
        $update2FaStatus = User::where('id', $this->user()->id)->update(['google2fa_status' => true]);
        if ($update2FaStatus) {
            Session::put('2fa', $this->user()->id);
            toastr()->success(lang('2FA Authentication has been enabled successfully', 'alerts'));
            return back();
        }

    }

    public function towFactorDisable(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_code' => ['required', 'numeric'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($this->user()->google2fa_secret, $request->otp_code);
        if ($valid == false) {
            toastr()->error(lang('Invalid OTP code', 'alerts'));
            return back();
        }
        $update2FaStatus = User::where('id', $this->user()->id)->update(['google2fa_status' => false]);
        if ($update2FaStatus) {
            if ($request->session()->has('2fa')) {
                Session::forget('2fa');
            }
            toastr()->success(lang('2FA Authentication has been disabled successfully', 'alerts'));
            return back();
        }
    }
}
