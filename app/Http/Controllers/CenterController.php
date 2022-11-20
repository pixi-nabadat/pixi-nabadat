<?php

namespace App\Http\Controllers;

use App\DataTables\CentresDataTable;
use App\Http\Requests\StoreCenterRequest as StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest as UpdateCenterRequest;
use App\Services\CenterService;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CenterService $centerService, private LocationService $locationService)
    {

    }

    public function index(CentresDataTable $dataTables, Request $request)
    {
        $loadRelation = ['location'];
        return $dataTables->with(['filters' => $request->all(), 'withRelations' => $loadRelation])->render('dashboard.centers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.centers.create', ['governorates' => $governorates]);
    }

    public function store(StoreCenterRequest $request)
    {
        try {
            DB::beginTransaction();
            $this->centerService->store($request->validated());
            $toast = [
                'title' => trans('lang.success'),
                'message' => 'Center Saved Successfully'
            ];
            DB::commit();
            return back()->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => trans('lang.error'),
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    public function edit($id)
    {
        $withRelation = ['attachments'];
        $center = $this->centerService->find($id, $withRelation);
        if (!$center) {
            $toast = [
                'type' => 'error',
                'title' => trans('error'),
                'message' => trans('lang.notfound')
            ];
            return back()->with('toast', $toast);
        }
        $location = $this->locationService->getLocationAncestors($center->location_id);
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.centers.edit', ['center' => $center, 'governorates' => $governorates, 'location' => $location]);
    }

    public function update($id, UpdateCenterRequest $request)
    {
        try {
            $this->centerService->update($id, $request->validated());
            $toast = [
                'type' => 'success',
                'title' => trans('lang.success'),
                'message' => 'Center updated Successfully'
            ];
            return back()->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => trans('lang.error'),
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->centerService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));

        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }


    public function changeStatus(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        try {
            $result =  $this->centerService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus

    public function changeStatusOfSupportAutoService(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        try {
            $result =  $this->centerService->changeSupportAutoServiceStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus

    public function show($id)
    {
        $withRelation = ['attachments'];
        $center = $this->centerService->find($id, $withRelation);
        $location = $this->locationService->getLocationAncestors($center->location_id);
        return view('dashboard.centers.show', ['center' => $center, 'location' => $location]);
    }
}
