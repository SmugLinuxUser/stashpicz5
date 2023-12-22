<?php

namespace App\Http\Controllers\Frontend\Storage;

use App\Http\Controllers\Controller;
use Cache;
use Exception;
use Storage;

class DigitaloceanController extends Controller
{
    public static function setCredentials($data)
    {
        setEnv('DGL_SPACES_KEY', $data->credentials->spaces_key);
        setEnv('DGL_SPACES_SECRET', $data->credentials->spaces_secret);
        setEnv('DGL_SPACES_ENDPOINT', $data->credentials->spaces_endpoint);
        setEnv('DGL_SPACES_REGION', $data->credentials->spaces_region);
        setEnv('DGL_SPACES_BUCKET', $data->credentials->spaces_bucket);
    }

    public static function upload($file, $location)
    {
        try {
            $filename = generateFileName($file);
            $path = $location . $filename;
            $disk = Storage::disk('digitalocean');
            $uploadToStorage = $disk->put($path, fopen($file, 'r+'));
            if ($uploadToStorage) {
                $data = [
                    "type" => "success",
                    "filename" => $filename,
                    "path" => $path,
                    "link" => $disk->url($path),
                ];
                return responseHandler($data);
            }
        } catch (Exception $e) {
            return responseHandler(["type" => "error", 'msg' => lang('Storage provider error', 'upload zone')]);
        }
    }

    public static function getFile($fileEntry)
    {
        try {
            $cachePrefex = 'secure_' . hashid($fileEntry->id);
            if (Cache::has($cachePrefex)) {
                return Cache::get($cachePrefex);
            } else {
                $file = Storage::disk('digitalocean')->get($fileEntry->path);
                $response = \Response::make($file, 200);
                $response->header("Content-Type", $fileEntry->mime);
                Cache::put($cachePrefex, $response);
                return $response;
            }
        } catch (Exception $e) {
            return brokenFile();
        }
    }

    public static function download($fileEntry)
    {
        try {
            $disk = Storage::disk('digitalocean');
            $filePath = $disk->path($fileEntry->path);
            if ($disk->has($filePath)) {
                return $disk->temporaryUrl($filePath, now()->addHour(), [
                    'ResponseContentDisposition' => 'attachment; filename="' . $fileEntry->name . '"',
                ]);
            } else {
                throw new Exception(lang('There was a problem while trying to download the file', 'image page'));
            }
        } catch (Exception $e) {
            throw new Exception(lang('There was a problem while trying to download the file', 'image page'));
        }
    }

    public static function delete($filePath)
    {
        $disk = Storage::disk('digitalocean');
        if ($disk->has($filePath)) {
            $disk->delete($filePath);
        }
        return true;
    }

}
