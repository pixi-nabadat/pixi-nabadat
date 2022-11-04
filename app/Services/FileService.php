<?php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;


class FileService
{
    protected $types = [
        "image" => ['jpg', 'jpeg', 'gif', 'png'],
        "master_plan" => ['jpg', 'jpeg', 'gif', 'png'],
        "pdf" => ['application/pdf'],
        "docx" => ['application/octet-stream'],
        "3DS" => ['application/3DS'],
        "zip" => ['application/x-zip-compressed'],
    ];

    function prepareImage ($image, $path)
    {
        $extension = $image->getClientOriginalExtension();
        $filename  = time().'.' . $extension;
        $image->move(public_path($path), $filename);

        return $filename;
    }

    public function upload($file, $type, $dir)
    {
        $fullDir = 'uploads/' . $dir;
        if (!file_exists($fullDir)) {
            createDir($fullDir . "file");
        }
        list($fileType, $file) = explode(';', $file);
        list(, $file) = explode(',', $file);
        $file = base64_decode($file);
        if ($type == 'image') {
            return $this->processImage($fileType, $fullDir, $file);
        } else {
            return $this->uploadFile($fileType, $fullDir, $file);
        }
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

    public function uploadFile($fileType, $fullDir, $file)
    {
        // $fullDir = 'uploads/' . $dir;
        // if (!file_exists($fullDir)) {
        //     createDir($fullDir . "file");
        // }
        // list($fileType, $file) = explode(';', $file);
        // list(, $file) = explode(',', $file);
        // $file = base64_decode($file);
        $fileTypes =  [
            'data:application/pdf' => 'pdf',
            'data:"application/octet-stream"' => 'docx',
            'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'data:text/csv' => 'xlsx',
            'data:application/octet-stream' => 'xls',
            'data:application/vnd.ms-excel' => 'xls',
            'application/x-zip-compressed' => 'zip',
            'data:"application/octet-stream"' => 'docx',
            'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document"'  => 'docx',
        ];
        $exe =  $fileTypes[$fileType];
        if (empty($exe)) {
            return [
                "status" => false,
                "message" => "File type not Supported",
                "code" => 203,
            ];
        }
        $fileName = uniqid() . "." . $exe;
        file_put_contents($fullDir . $fileName, $file);
        return [
            "dir" => url('/') .'/'. $fullDir,
            "file_name" => $fileName
        ];
    }

    private function processImage($fileType, $fullDir, $file)
    {
        $fileType = explode("image/", $fileType);
        $exe = strtolower($fileType[1] ?? "");

        $img = Image::make($file);
        $size = $img->filesize();
        if ($size > 400000) {
            $img->resize(1500, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $fileName = uniqid() . "." . $exe;
        $img->save($fullDir . $fileName);
        return [
            "dir" => url('/') . '/' . $fullDir,
            "file_name" => $fileName
        ];
    }

    public function removeFile($dir, $fileName)
    {
        $fullDir = "uploads/" . $dir;
        $disk = Storage::build([
            'driver' => 'public_uploads',
            'root' => $fullDir,
        ]);
        if ($disk->exists($fileName)) {
            $disk->delete($fileName);
            return [
                "status" => true,
                "message" => 'File Deleted Successflly'
            ];
        } else {
            return false;
        }
    }
}
