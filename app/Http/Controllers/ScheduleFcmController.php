<?php

namespace App\Http\Controllers;

use App\DataTables\ScheduleFcmDatatable;
use App\Enum\FcmEventsNames;
use App\Http\Requests\ScheduleFcmStoreRequest;
use App\Http\Requests\ScheduleFcmUpdateRequest;
use Illuminate\Http\Request;
use App\Services\ScheduleFcmService;

class ScheduleFcmController extends Controller
{

    public function __construct(private ScheduleFcmService $scheduleFcmService)
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,ScheduleFcmDatatable $dataTable)
    {
        userCan(request: $request, permission: 'view_schedule_fcm');
        $withRelations = [];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $fcm_channels = FcmEventsNames::$CHANNELS;
        $triggers = FcmEventsNames::$EVENTS;
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.marketing.schedule-fcm.index', compact('fcm_channels', 'triggers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        userCan(request: $request, permission: 'create_fcm');
        $flags = FcmEventsNames::$FLAGS;
        $fcm_channels = FcmEventsNames::$CHANNELS;
        $triggers = FcmEventsNames::$EVENTS;
        return  view('dashboard.marketing.schedule-fcm.create',compact('flags','fcm_channels','triggers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleFcmStoreRequest $request)
    {
        userCan(request: $request, permission: 'create_fcm');
        try {
            $data = $request->validated();
            $this->scheduleFcmService->store($data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('schedule-fcm.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_schedule_fcm');
        $scheduleFcm = $this->scheduleFcmService->find($id);
        if (!$scheduleFcm)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.schedule_fcm_not_found')];
            return back()->with('toast', $toast);
        }
        $flags = FcmEventsNames::$FLAGS;
        $fcm_channels = FcmEventsNames::$CHANNELS;
        $triggers = FcmEventsNames::$EVENTS;
        return view('dashboard.marketing.schedule-fcm.edit', compact('scheduleFcm','flags','fcm_channels','triggers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleFcmUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_schedule_fcm');
        try {
            $data = $request->validated();
            $this->scheduleFcmService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('schedule-fcm.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_schedule_fcm');
        try {
            $result = $this->scheduleFcmService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * status method for change is_active column only
     */
    public function status(Request $request)
    {
        userCan(request: $request, permission: 'change_schedule_fcm_status');
        try {
            $result = $this->scheduleFcmService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}