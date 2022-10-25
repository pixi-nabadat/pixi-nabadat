<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\GovernoratesDataTable;
use App\Http\Requests\StoreLocationRequest;
use App\Services\LocationService;

class GovernorateController extends Controller
{

    public function __construct(private LocationService $locationService)
    {

    }

    public function index(GovernoratesDataTable $dataTables,Request $request)
    {
        $request = $request->merge(['depth'=> 1,'is_active'=>$request->is_active??1]);
        return $dataTables->with(['filters'=>$request->all()])->render('dashboard.locations.governorate.index');
    }

    public function getAllGovernorates(Request $request)
    {
        $filter =[
            // 'depth'=> 1,
            'is_active'=>1,
            'parent' =>  $request->country_id,
        ];
        $governorates = $this->locationService->getAll($filter);
        return $governorates;
    }

    public function create()
    {
        $filter = ['depth'=> 0];
        $countries = $this->locationService->getAll($filter);
        return view('dashboard.locations.governorate.create',['countries'=>$countries]);
    }

    public function store(StoreLocationRequest $request)
    {
        try {
            $this->locationService->store($request->all());
            $toast=[
                'type'=>'success',
                'title'=>trans('lang.title'),
                'message'=> 'governorate saved Successfully'
            ];
            return back()->with('toast',$toast);
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
        $governorate = $this->locationService->getLocationById($id);
        if (!$governorate)
        {
            $toast = [
              'type'=>'error',
              'title'=>trans('error'),
              'message'=>trans('lang.notfound')
            ];
            return back()->with('toast',$toast);
        }
        $filter =[
            'depth'=> 0,
            'is_active'=>1
        ];
        $countries = $this->locationService->getAll($filter);
        return view('dashboard.locations.governorate.edit',['governorate' => $governorate, 'countries' =>$countries]);
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
            return  redirect(route('governorate.index'))->with('toast',$toast);
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
