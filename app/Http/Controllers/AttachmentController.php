<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocationRequest;
use App\DataTables\CountriesDataTable;
use App\Services\LocationService;

class AttachmentController extends Controller
{

    public function destroy($id)
    {
        try {
            $attachment =  Attachment::find($id);
            if(!$attachment)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            $attachment->delete();
            unlink(public_path($attachment->path."\\".$attachment->filename));
            return apiResponse(message: trans('lang.success'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }

    public function show($id)
    {

    }
}