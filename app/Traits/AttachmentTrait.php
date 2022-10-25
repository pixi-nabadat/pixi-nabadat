<?php

namespace App\Traits;
use App\Models\Attachment;
use App\Services\FileService;
use Illuminate\Support\Facades\Storage;
trait AttachmentTrait
{
    public function uploadAttachment($file, $path)
    {
        $fileService = new FileService();
        $extension = $file->getClientOriginalExtension();
        if (in_array($extension , Attachment::$types['image']) ) {
            return $fileService->uploadImage($file, $extension,$path);
        } else {
            return $fileService->uploadFile($file , $extension, $path);
        }
    }

    public function storeAttachment($file, $path)
    {
        $fileService = new FileService();
        $filename = $fileService->prepareImage($file, $path);
        return $filename;
    }

    private function removeAttachment($fileName, $path)
    {
        Storage::disk('public_uploads')->delete($path.$fileName);
        return true;
    }

}
