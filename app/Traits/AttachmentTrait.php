<?php

namespace App\Traits;
use App\Models\Attachment;
use App\Managers\FileManager;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
trait AttachmentTrait
{
    private function uploadAttachment($file, $path)
    {
        $extension = $file->file('file')->getClientOriginalExtension();
        if (in_array($extension , Attachment::$types['image']) ) {
            $manager = new ImageService();
            return $manager->store($file, $extension,$path);
        } else {
            $manager = new FileManager();
            return $manager->store($file , $extension, $path);
        }
    }

    private function removeAttachment($fileName, $path)
    {
        Storage::disk('public_uploads')->delete($path.$fileName);
        return true;
    }

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
