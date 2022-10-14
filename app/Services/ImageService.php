<?php

namespace App\Services;

use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class ImageService extends BaseService
{
    public function store($file , $extension, $fullDir)
    {
        $img = Image::make($file['file']);
        $size = $img->filesize();
        if ($size > 400000) {
            $img->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $fileName = uniqid() . "." . $extension;
        if (!file_exists($fullDir)) {
            createDir($fullDir . "file");
        }
        $path = $fullDir.$fileName;
        $img->save(Storage::disk('public_uploads')->put($fullDir, $file['file']));
        return $path;
    }
}
