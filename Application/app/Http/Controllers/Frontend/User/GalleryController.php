<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class GalleryController extends Controller
{
    public function index()
    {
        if (request()->has('search')) {
            $q = request()->input('search');
            $fileEntries = FileEntry::where(function ($query) {
                $query->currentUser();
            })->where(function ($query) use ($q) {
                $query->where('shared_id', 'like', '%' . $q . '%')
                    ->OrWhere('name', 'like', '%' . $q . '%')
                    ->OrWhere('filename', 'like', '%' . $q . '%')
                    ->OrWhere('mime', 'like', '%' . $q . '%')
                    ->OrWhere('size', 'like', '%' . $q . '%')
                    ->OrWhere('extension', 'like', '%' . $q . '%');
            })->notExpired()->orderByDesc('id')->paginate(20);
            $fileEntries->appends(['search' => $q]);
        } else {
            $fileEntries = FileEntry::currentUser()->notExpired()->orderbyDesc('id')->paginate(15);
        }
        return view('frontend.user.gallery.index', ['fileEntries' => $fileEntries]);
    }

    public function edit($shared_id)
    {
        $fileEntry = FileEntry::where('shared_id', $shared_id)->currentUser()->notExpired()->firstOrFail();
        return view('frontend.user.gallery.edit', ['fileEntry' => $fileEntry]);
    }

    public function update(Request $request, $shared_id)
    {
        $fileEntry = FileEntry::where('shared_id', $shared_id)->currentUser()->notExpired()->first();
        if (is_null($fileEntry)) {
            toastr()->error(lang('Image not found, missing or expired please refresh the page and try again', 'alerts'));
            return back();
        }
        $validator = Validator::make($request->all(), [
            'filename' => ['required', 'string', 'max:255'],
            'access_status' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'max:255'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->has('password') && !is_null($request->password)) {
            if (uploadSettings()->upload->password_protection) {
                $request->password = Hash::make($request->password);
            } else {
                $request->password = null;
            }
        }
        $update = $fileEntry->update([
            'name' => $request->filename,
            'access_status' => $request->access_status,
            'password' => $request->password,
        ]);
        if ($update) {
            toastr()->success(lang('Updated successfully', 'gallery'));
            return back();
        }
    }

    public function download($shared_id)
    {
        if (!uploadSettings()->upload->allow_downloading) {
            toastr()->error(lang('There was a problem while trying to download the image', 'alerts'));
            return back();
        }
        $fileEntry = FileEntry::where('shared_id', $shared_id)->currentUser()->notExpired()->firstOrFail();
        try {
            $handler = $fileEntry->storageProvider->handler;
            $download = $handler::download($fileEntry);
            if ($fileEntry->storageProvider->symbol == "local") {
                return $download;
            } else {
                return redirect($download);
            }
        } catch (Exception $e) {
            toastr()->error(lang('There was a problem while trying to download the image', 'alerts'));
            return redirect()->route('user.gallery.index');
        }
    }

    public function destroy($shared_id)
    {
        $fileEntry = FileEntry::where('shared_id', $shared_id)->currentUser()->notExpired()->firstOrFail();
        try {
            $handler = $fileEntry->storageProvider->handler;
            $delete = $handler::delete($fileEntry->path);
            if ($delete) {
                $fileEntry->delete();
                toastr()->success(lang('Deleted successfully', 'gallery'));
                return redirect()->route('user.gallery.index');
            }
        } catch (\Exception$e) {
            toastr()->error(lang('There was a problem while trying to delete the image', 'gallery'));
            return back();
        }
    }

    public function destroyAll(Request $request)
    {
        if (empty($request->ids)) {
            toastr()->error(lang('You have not selected any image', 'gallery'));
            return back();
        }
        $ids = explode(',', $request->ids);
        foreach ($ids as $shared_id) {
            $fileEntry = FileEntry::where('shared_id', $shared_id)->currentUser()->notExpired()->first();
            if (!is_null($fileEntry)) {
                try {
                    $handler = $fileEntry->storageProvider->handler;
                    $delete = $handler::delete($fileEntry->path);
                    if ($delete) {
                        $fileEntry->delete();
                    }
                } catch (\Exception$e) {
                    toastr()->error(lang('Image not found, missing or expired please refresh the page and try again', 'alerts'));
                    return back();
                }
            }
        }
        toastr()->success(lang('Deleted successfully', 'gallery'));
        return back();
    }
}
