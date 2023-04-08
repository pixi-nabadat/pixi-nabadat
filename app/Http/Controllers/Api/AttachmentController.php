<?php

namespace App\Http\Controllers\Api;

use App\Enum\ImageTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DoctorService;
use App\Http\Requests\StoreDoctorRequest;
use App\Exceptions\BadRequestHttpException;
use App\Http\Requests\StoreGalaryRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\Attachment;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AttachmentController extends Controller
{
    public function storeInGalary(StoreGalaryRequest $request)
    {
        try{
            $data = $request->validated();
            $user = Auth::user();
            $center = $user->center;
            if(isset($center))
            {
                if (isset($data['image']))
                {
                    $fileData = FileService::saveImage(file: $data['image'],path: 'uploads\centers', field_name: 'image');
                    $fileData['type'] = ImageTypeEnum::GALARY;
                    $center->storeAttachment($fileData);
                }
                return apiResponse(data: new AuthUserResource($user), message: trans('lang.success_operation'));
            }
            else{
                return apiResponse(message: trans('lang.user_is_not_center'), code: 422);
            }

        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(),code: 422);
        }     
    }

    public function deleteAttachment(int $id)
    {
        try {
            $attachment =  Attachment::find($id);
            if(!$attachment)
                return apiResponse(message: trans('lang.attachment_not_found'),code: 404);
            unlink(public_path($attachment->path."/".$attachment->filename));
            $attachment->delete();
            return apiResponse(message: trans('lang.success'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }
}
