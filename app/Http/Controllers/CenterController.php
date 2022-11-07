<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CenterService;
use App\DataTables\CentresDataTable;
use App\Http\Requests\StoreCenterRequest as StoreCenterRequest;
use App\Http\Requests\StoreCenterRequest as UpdateCenterRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CenterService $centerService,private LocationService $locationService)
    {

    }

    public function index(CentresDataTable $dataTables,Request $request)
    {
        $request = $request->merge(['is_active' =>1]);
        $loadRelation = ['location'];
        return $dataTables->with(['filters'=>$request->all(),'withRelations'=>$loadRelation])->render('dashboard.centers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $filters =['depth'=>0,'is_active'=>1];
        $countries = $this->locationService->getAll($filters);
        return view('dashboard.centers.create',['countries' => $countries]);
    }

    public function store(StoreCenterRequest $request)
    {
        try {
            $this->centerService->store($request->except('_token'));
            $toast=[
                'type'=>'sucess',
                'title'=>trans('lang.success'),
                'message'=> 'Center Saved Successfully'
            ];
            return back()->with('toast',$toast);
        } catch (\Exception $exception) {
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
        $withRelation = ['attachments'];
        $center = $this->centerService->find($id,$withRelation);
        if (!$center)
        {
            $toast = [
                'type'=>'error',
                'title'=>trans('error'),
                'message'=>trans('lang.notfound')
            ];
            return back()->with('toast',$toast);
        }
        $location = $this->locationService->GetLocationAncestors($center->location_id);
        $filters =['depth'=>0,'is_active'=>1];
        $countries = $this->locationService->getAll($filters);
        return view('dashboard.centers.edit',['center' => $center,'countries' => $countries,'location' =>$location]);
    }

    public function update($id, UpdateCenterRequest $request)
    {
        try {
            $this->centerService->update($id, $request->except(['_token','_method']));
            $toast=[
                'type' => 'success',
                'title'=>trans('lang.success'),
                'message'=>'Center updated Successfully'
            ];
            return back()->with('toast',$toast);
            // return  redirect(route('centers.index'))->with('toast',$toast);
        } catch (\Exception $exception) {
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
            $result =  $this->centerService->delete($id);
            if(!$result)
                return apiResponse(message: trans('lang.not_found'),code: 404);
            return apiResponse(message: trans('lang.success'));

        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }

    public function changeStatus($id)
    {
        $this->centerService->changeStatus($id);
        $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
        return redirect(route('centers.index'))->with('toast', $toast);
    }

    public function show($id)
    {

    }
}
