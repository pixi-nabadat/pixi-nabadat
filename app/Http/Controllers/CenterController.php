<?php

namespace App\Http\Controllers;

use App\DataTables\CentresDataTable;
use App\Events\PushEvent;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest ;
use App\Models\FcmMessage;
use App\Models\Location;
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
        userCan(request: $request, permission: 'view_center');
        $loadRelation = ['user.location'];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $governoratesFilters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($governoratesFilters);
        return $dataTables->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.centers.index', ['governorates'=>$governorates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_center');
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.centers.create', ['governorates' => $governorates]);
    }

    public function store(StoreCenterRequest $request): \Illuminate\Http\RedirectResponse
    {
        userCan(request: $request, permission: 'create_center');
        try {
            DB::beginTransaction();
            $center = $this->centerService->store($request->validated());
            $toast = [
                'title' => trans('lang.success'),
                'message' => trans('lang.center_created_successfully')
            ];
            DB::commit();
            event(new PushEvent($center,FcmMessage::DEAL_WITH_NEW_CENTER));
            return redirect()->route('centers.index')->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => trans('lang.error'),
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_center');
        try {
            $withRelation = ['user.attachments','attachments'];
            $center = $this->centerService->find($id, $withRelation);
            $governorates = $this->locationService->getAll(['depth' => 1, 'is_active' => 1]);  
            return view('dashboard.centers.edit', ['center' => $center, 'governorates' => $governorates]);
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => trans('error'),
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    public function update($id, UpdateCenterRequest $request)
    {
        userCan(request: $request, permission: 'edit_center');
        try {
            $this->centerService->update($id, $request->validated());
            $toast = [
                'title' => trans('lang.success'),
                'message' => trans('lang.center_updated_successfully')
            ];
            return redirect()->route('centers.index')->with('toast', $toast);
        } catch (\Exception $exception) {
            $toast = [
                'type' => 'error',
                'title' => trans('lang.error'),
                'message' => $exception->getMessage()
            ];
            return back()->with('toast', $toast);
        }
    }

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_center');
        try {
            $this->centerService->delete($id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }


    public function changeStatus(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        cache()->forget('home-api');

        try {
            $this->centerService->changeStatus($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus

    public function changeStatusOfSupportAutoService(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

        try {
            $result = $this->centerService->changeSupportAutoServiceStatus($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of changeStatus

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_center');
        $withRelation = ['user.attachments', 'attachments', 'devices'];
        $center = $this->centerService->find($id, $withRelation);
        $location = $this->locationService->getLocationAncestors($center->location_id);

        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.centers.show', ['center' => $center, 'governorates' => $governorates, 'location' => $location]);
    }

    public function featured(Request $request)
    {
        cache()->forget('home-api');
        try {
            $this->centerService->featured($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }
}
