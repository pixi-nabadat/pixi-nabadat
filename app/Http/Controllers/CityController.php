<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CitiesDataTable;
use App\Services\LocationService;
use App\Http\Requests\StoreLocationRequest;
use App\Traits\AttachmentTrait;
class CityController extends Controller
{
    use AttachmentTrait;

    public function __construct(private LocationService $locationService)
    {

    }

    public function storeFile(Request $request)
    {
        // $file = $request->file('file');

        $path = 'user/';
        $path = $this->storeAttachment($request->image,$path);
        dd($path);
    }

    public function showFile()
    {
        $PhotoPath = fileDir('profile_photo');
        $file = $PhotoPath.'JeLmxmSttDfl7O7NfMecduLLUBUEjHhnYIuKvj26.png';
        dd($file);
        return view('dashboard.show_file',['file' => $file]);
    }

    public function index(CitiesDataTable $dataTables,Request $request)
    {
        $request = $request->merge(['depth'=>2,'is_active'=>$request->is_active??1]);
        return $dataTables->with(['filters'=>$request->all()])->render('dashboard.locations.city.index');
    }

    public function create()
    {
        $filter = ['depth'=> 1];
        $governorates = $this->locationService->getAll($filter);
        return view('dashboard.locations.city.create',['governorates'=>$governorates]);
    }

    public function store(StoreLocationRequest $request)
    {
        try {
            return $this->locationService->store($request->all());
        }catch (\Exception $exception)
        {
            $toast=[
                'type'=>'error',
                'title'=>trans('lang.error'),
                'message'=>$exception->getMessage()
            ];
            return back()->with('toast',$toast);
        }
    }

    public function edit($id)
    {
        $city = $this->locationService->getLocationById($id);
        if (!$city)
        {
            $toast = [
              'type'=>'error',
              'title'=>trans('error'),
              'message'=>trans('lang.notfound')
            ];
            return back()->with('toast',$toast);
        }
        $filter =[
            'depth'=> 1,
            'is_active'=>1
        ];
        $governorates = $this->locationService->getAll($filter);
        return view('dashboard.locations.city.edit',['city' => $city, 'governorates' =>$governorates]);
    }

    public function update($id, StoreLocationRequest $request)
    {
        try {
            $this->locationService->update($id, $request->all());
            $toast=[
                'type' => 'success',
                'title'=>trans('lang.success'),
                'message'=>trans('lang.success')
            ];
            return  redirect(route('city.index'))->with('toast',$toast);
        }catch (\Exception $exception)
        {
            $toast = [
                'type'=>'error',
                'title'=>trans('lang.error'),
                'message'=>$exception->getMessage()
            ];
            return back()->with('toast',$toast);
        }
    }

    public function destroy($id)
    {
        try {
            $result =  $this->locationService->delete($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
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
