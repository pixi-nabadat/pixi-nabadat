<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DoctorService;
use App\Http\Requests\StoreDoctorRequest;
use App\Exceptions\BadRequestHttpException;
use App\Services\FileService;

class AttachmentController extends Controller
{
    public function upload(Request $request)
    {
//        $file = $request->file;
//        $manager = new FileService;
//        if (is_array($file) && !empty($file['src'])) {
//            $src = $file['src'];
//            if (!$request->has('file') || !$request->has('type')) {
//                return response()->json(
//                    [
//                        "status" => false,
//                        "message" => "missing inputs",
//                        "code" => 204,
//                    ], 411);
//            }
//            $output = $manager->upload($src, $request->type, $request->path);
//            return response()->json($output);
//        } else {
//            $extension = $request->file->getClientOriginalExtension();
//            return $manager->uploadImage($file, $request->path, $extension);
//        }
    }
}
