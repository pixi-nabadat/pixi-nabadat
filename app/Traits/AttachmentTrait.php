<?php

namespace App\Traits;
use App\Models\Attachment;
use App\Services\FileService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
trait AttachmentTrait
{
    private function uploadAttachment($file, $path)
    {
        $fileService = new FileService();
        $extension = $file->getClientOriginalExtension();
        if (in_array($extension , Attachment::$types['image']) ) {
            return $fileService->uploadImage($file, $extension,$path);
        } else {
            return $fileService->uploadFile($file , $extension, $path);
        }
    }

    private function storeAttachment($file, $path)
    {
        $fileService = new FileService();
        $extension = $file->getClientOriginalExtension();
        if (in_array($extension , Attachment::$types['image']) ) {
            return $fileService->storeImage($file, $extension,$path);
        } else {
            return $fileService->storeFile($file , $extension, $path);
        }
    }

    private function removeAttachment($fileName, $path)
    {
        Storage::disk('public_uploads')->delete($path.$fileName);
        return true;
    }

}
