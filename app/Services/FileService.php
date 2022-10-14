<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class FileService
{
    public function storeFile($file , $extension, $fullDir)
    {
        $fileName = uniqid() . "." . $extension;
        if (!file_exists($fullDir)) {
            createDir($fullDir . "file");
        }
        $path = $fullDir.$fileName;
        Storage::disk('public_uploads')->put($fullDir, $file['file']);
        return $path;
    }

    public function uploadImage($file, $dir, $exe)
    {
        $fullDir = 'uploads/'.$dir;
        if (!file_exists($fullDir)) {
            createDir($fullDir . "file");
        }
        $img = Image::make($file);
        //save image to directory
        $fileName = uniqid() . "." . $exe;
        $img->save($fullDir . $fileName);
        return [
            "status" => true,
            "dir" => url('/') . $fullDir,
            "file_name" => $fileName
        ];
    }
}
