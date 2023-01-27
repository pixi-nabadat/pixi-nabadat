<?php

namespace App\Http\Controllers;

use App\DataTables\CentresDataTable;
use App\Http\Requests\StoreCenterRequest;
use App\Http\Requests\UpdateCenterRequest ;
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
        $loadRelation = ['user.location'];
        $filters = $request->filters ?? [];
        return $dataTables->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.centers.index');
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

    public function store(StoreCenterRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            DB::beginTransaction();
            $this->centerService->store($request->validated());
            $toast = [
                'title' => trans('lang.success'),
                'message' => trans('lang.center_created_successfully')
            ];
            DB::commit();
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

    public function edit($id)
    {
        try {
            $withRelation = ['user','attachments','defaultLogo'];
            $center = $this->centerService->find($id, $withRelation);
            $locations = $this->locationService->getLocationAncestors($center->user->location_id);
            $locations = $locations->whereNotNull('parent_id');
            $governorate = $locations->first() ;
            $governorate_id = $governorate->id ;
            $filters = ['depth' => 1, 'is_active' => 1];
            $governorates = $this->locationService->getAll($filters);
            $cites =$governorate->descendants;
            return view('dashboard.centers.edit', ['center' => $center, 'governorates' => $governorates,'selected_governorate'=>$governorate_id, 'cities' => $cites]);
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

    public function destroy($id)
    {
        try {
            $this->centerService->delete($id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }


    public function changeStatus(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {

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

    public function show($id)
    {
        $withRelation = ['attachments'];
        $center = $this->centerService->find($id, $withRelation);
        $location = $this->locationService->getLocationAncestors($center->location_id);

        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.centers.show', ['center' => $center, 'governorates' => $governorates, 'location' => $location]);
    }

    public function featured(Request $request)
    {
        try {
            $this->centerService->featured($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }
}
