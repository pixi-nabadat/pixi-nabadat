<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Image;
use Intervention\Image\Constraint;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    
    /**
     * Save the uploaded image.
     *
     * @param UploadedFile $file     Uploaded file.
     * @param int $maxWidth
     * @param string|null $path
     *
     * @return array File name.
     */
    public static function saveImage(UploadedFile $file, int $maxWidth = 576, string $path = null)
    {

        $fileName = self::getFileName($file);
        $fileExt = self::getFileExtenetion($file);
        $fileSize = self::getFileSize($file);
        $img = self::makeImage($file);
        $img = self::resizeImage($img, $maxWidth);
        self::uploadImage($img, $fileName, $path);

        return [
            'filename'=>$fileName,
            'extention'=>$fileExt,
            'size'=>$fileSize,
            'path'=>$path
        ];
    }

    /**
     * Get uploaded file's name.
     *
     * @param UploadedFile $file
     *
     * @return null|string
     */
    protected static function getFileName(UploadedFile $file)
    {
        $filename = $file->getClientOriginalName();
        $filename = date('Ymd') . '_' . time() . '.' . pathinfo($filename, PATHINFO_EXTENSION);
        return $filename;
    }

    protected static function getFileExtenetion(UploadedFile $file)
    {
        return  $file->getClientOriginalExtension();
    }

    protected static function getFileSize(UploadedFile $file)
    {
        return  $file->getSize();
    }

    /**
     * Create the image from upload file.
     *
     * @param UploadedFile $file
     *
     * @return \Intervention\Image\Image
     */
    protected static function makeImage(UploadedFile $file)
    {
        return Image::make($file);
    }

    /**
     * Resize image to the configured size.
     *
     * @param \Intervention\Image\Image $img
     * @param int $maxWidth
     *
     * @return \Intervention\Image\Image
     */
    protected static function resizeImage(\Intervention\Image\Image $img, int $maxWidth = 576)
    {
        $img->resize($maxWidth, null, function (Constraint $constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $img;
    }

    /**
     * Save the uploaded image to the file system.
     *
     * @param \Intervention\Image\Image $img
     * @param string                    $fileName
     * @param string                    $path
     */
    protected static function uploadImage($file, $fileName, $path)
    {
        $destinationPath = public_path($path);
        if(!File::isDirectory($destinationPath)){
            //make the directory because it doesn't exists
            File::makeDirectory($destinationPath, 0777, true, true);
        }
        $file->save($destinationPath ."/". $fileName);
    }

    public static function remove(string $path)
    {
        if(File::exists($path)){
            File::delete($path);
        }
        File::delete($path);
    }
}
