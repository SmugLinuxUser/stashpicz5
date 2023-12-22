<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Methods\UploadSettingsManager;
use App\Models\FileEntry;
use App\Models\StorageProvider;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Str;
use Validator;
use FFMpeg;
use Image;
use Storage;
use ProtoneMedia\LaravelFFMpeg\Filters\WatermarkFactory;
class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedFile = $request->file('file');
        $uploadedFileName = $uploadedFile->getClientOriginalName();
        $validator = Validator::make($request->all(), [
            'password' => ['nullable', 'max:255'],
            'upload_auto_delete' => ['required', 'integer', 'min:0', 'max:365'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return static::errorResponseHandler($error . ' (' . $uploadedFileName . ')');
            }
        }
        $allowedTypes = explode(',', allowedTypes());
        if (!in_array($request->type, $allowedTypes)) {
            return static::errorResponseHandler(lang('You cannot upload files of this type.', 'upload zone'));
        }
        $uploadSettings = UploadSettingsManager::handler();
        if (!$uploadSettings->active) {
            return static::errorResponseHandler(lang('Login or create account to start uploading images', 'upload zone'));
        }
        if (!array_key_exists($request->upload_auto_delete, autoDeletePeriods())) {
            return static::errorResponseHandler(lang('Invalid file auto delete time', 'upload zone'));
        } else {
            if (autoDeletePeriods()[$request->upload_auto_delete]['days'] != 0) {
                $expiryAt = autoDeletePeriods()[$request->upload_auto_delete]['datetime'];
            } else {
                $expiryAt = null;
            }
        }
        if ($request->has('password') && !is_null($request->password) && $request->password != "undefined") {
            if ($uploadSettings->upload->password_protection) {
                $request->password = Hash::make($request->password);
            } else {
                $request->password = null;
            }
        }
        if (!is_null($uploadSettings->upload->file_size)) {
            if ($request->size > $uploadSettings->upload->file_size) {
                return static::errorResponseHandler(str_replace('{maxFileSize}', $uploadSettings->formates->file_size, lang('File is too big, Max file size {maxFileSize}', 'upload zone')));
            }
        }
        if (!is_null($uploadSettings->storage->remining->number)) {
            if ($request->size > $uploadSettings->storage->remining->number) {
                return static::errorResponseHandler(lang('insufficient storage space please ensure sufficient space', 'upload zone'));
            }
        }
        $storageProvider = StorageProvider::where([['symbol', env('FILESYSTEM_DRIVER')], ['status', 1]])->first();
        if (is_null($storageProvider)) {
            return static::errorResponseHandler(lang('Unavailable storage provider', 'upload zone'));
        }
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));
        try {
            if ($receiver->isUploaded() === false || hasUploaded() == false) {
                return static::errorResponseHandler(str_replace('{filename}', $uploadedFileName, lang('Failed to upload ({filename})', 'upload zone')));
            }
            $save = $receiver->receive();
            if ($save->isFinished() && hasUploaded() == true) {
                $file = $save->getFile();
                $fileName = $file->getClientOriginalName();
                $fileMimeType = $file->getMimeType();
                $fileExtension = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();
				
                if (!in_array($fileExtension, ['mp4', 'jpg', 'png', 'webm', 'PNG', 'gif', 'jpeg', 'mov','MOV', 'gif'])) {
                    return static::errorResponseHandler(lang('You cannot upload files of this type.', 'upload zone'));
                }
                if ($fileSize == 0) {
                    return static::errorResponseHandler(lang('Empty files cannot be uploaded', 'upload zone'));
                }
                if (!is_null($uploadSettings->upload->file_size)) {
                    if ($fileSize > $uploadSettings->upload->file_size) {
                        return static::errorResponseHandler(str_replace('{maxFileSize}', $uploadSettings->formates->file_size, lang('File is too big, Max file size {maxFileSize}', 'upload zone')));
                    }
                }
                if (!is_null($uploadSettings->storage->remining->number)) {
                    if ($fileSize > $uploadSettings->storage->remining->number) {
                        return static::errorResponseHandler(lang('insufficient storage space please ensure sufficient space', 'upload zone'));
                    }
                }
                if(in_array($fileExtension, ['mp4', 'webm', 'mov', 'MOV']) and $fileMimeType != "video/mp4"){
                    $fileMimeType = "video/mp4";
                    
                    
    
    
                }				
                $ip = vIpInfo()->ip;
                $sharedId = Str::random(15);
                $userId = (Auth::user()) ? Auth::user()->id : null;
                $location = (Auth::user()) ? "uploads/users/" . hashid(userAuthInfo()->id) . "/" : "uploads/guests/";
                $handler = $storageProvider->handler;
                $uploadResponse = $handler::upload($file, $location);
                if ($uploadResponse->type == "error") {
                    return $uploadResponse;
                }
                // Set the path to the original image and the watermark image

 if($request->watermark != 'undefined' and $request->watermark != 'None' or $request->dmca != 'undefined' and $request->dmca != 'None'){               
$originalImagePath = Storage::disk('digitalocean')->get($uploadResponse->path);
$watermarkImagePath = './images/favicon.png';

// Set the output path for the watermarked image
if(strpos($fileMimeType, 'video') === 0){
    // VIDEO WATERMARK
    $yes = "app/public/" . (Auth::user()) ? "/uploads/users/" . hashid(userAuthInfo()->id) . "/" : "/app/public/uploads/guests/";
    $disk = Storage::disk('digitalocean');
    $hope = storage_path($yes);
    $watermarkPath = storage_path("app/public/" . "uploads/users/" . hashid(userAuthInfo()->id) . "/") . "watermark.jpg";


 // Path to the output video

// Execute FFmpeg command to add watermark
$command = "ffmpeg -i $file -i $watermarkPath -filter_complex '[1][0]scale2ref=oh*mdar:ih*0.2[logo][video];[video][logo]overlay' './images/help.mp4'";
shell_exec($command);
$savedFile = public_path('./images/' . 'help.mp4');
$disk->put($yes . $uploadResponse->filename, fopen($savedFile, 'r+'), 'public');
unlink($savedFile);
} else{

    
   // Create an instance of Intervention Image
   $image = Image::make($originalImagePath);
   
   // Get the path to the watermark image file
   $yes = "app/public/" . (Auth::user()) ? "/uploads/users/" . hashid(userAuthInfo()->id) . "/" : "/app/public/uploads/guests/";
   $hope = storage_path($yes);
   $watermarkPath = storage_path("app/public/" . "uploads/users/" . hashid(userAuthInfo()->id) . "/") . "watermark.jpg";
   $watermark = Image::make($watermarkPath);
   $watermark->resize($request->Wsize, null, function ($constraint) {
    $constraint->aspectRatio();
});

   // Insert the watermark onto the image
   if($request->dmca != 'None'){
   $image->insert(public_path('./images' . '/' . 'dmca_protect.png'), $request->dmca, 50, 50);
   }
   if($request->watermark != 'undefined' and $request->watermark != 'None'){
    
   $image->insert($watermark, $request->watermark, 10, 10);
    
   }
   
   // Save the modified image
   $image->save(public_path('./images/' . $uploadResponse->filename));
   $disk = Storage::disk('digitalocean');
   $savedFile = public_path('./images/' . $uploadResponse->filename);
   $uploadToStorage = $disk->put($yes . $uploadResponse->filename, fopen($savedFile, 'r+'));
   unlink($savedFile);
   
}
   
   
 }

 if(strpos($fileMimeType, 'video') === 0){
    $remoteFile = route('file.secure', $uploadResponse->filename);
    $savedFile = public_path('./images/' . 'ass.mp4');
    $localFile = $file;
    $thumbnail = "thumbnail-" . str_replace(" ", "", $uploadResponse->filename) . ".gif";
    $finalD = "./images/thumbnails/" . $thumbnail;
    $asa = Storage::disk('digitalocean')->get($uploadResponse->path);
   
    

    // Execute FFmpeg command to convert the video to GIF
    $ffmpegCommand = "ffmpeg -i $localFile -vf 'fps=10,scale=320:-1:flags=lanczos' $finalD";
    exec($ffmpegCommand, $output, $returnCode);
    
    
 }

                $createFileEntry = FileEntry::create([
                    'ip' => $ip,
                    'shared_id' => $sharedId,
                    'user_id' => $userId,
                    'storage_provider_id' => $storageProvider->id,
                    'name' => $fileName,
                    'mime' => $fileMimeType,
                    'size' => $fileSize,
                    'extension' => $fileExtension,
                    'filename' => $uploadResponse->filename,
                    'path' => $uploadResponse->path,
                    'link' => $uploadResponse->link,
                    'password' => $request->password,
                    'expiry_at' => $expiryAt,
					'nsfw' => $request->nsfw,
                ]);

                return response()->json([
                    'type' => 'success',
                    'file_name' => $createFileEntry->name,
                    'file_id' => $createFileEntry->shared_id,
                    'file_link' => route('file.view', $createFileEntry->shared_id),
                    'direct_link' => route('file.secure', $createFileEntry->filename),
                ]);
            }
        } catch (Exception $e) {
            return static::errorResponseHandler(str_replace('{filename}', $e, lang('Failed to upload ({filename})', 'upload zone')));
        }
    }

    private static function errorResponseHandler($response)
    {
        return response()->json(['type' => 'error', 'msg' => $response]);
    }
}

