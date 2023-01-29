<?php

namespace App\Http\Controllers;

use App\DataTables\FcmMessagesDatatable;
use App\Enum\FcmEventsNames;
use App\Http\Requests\FcmMessageStoreRequest;
use App\Http\Requests\FcmMessageUpdateRequest;
use App\Services\FcmMessageService;
use Illuminate\Http\Request;

class FcmMessageController extends Controller
{

    public function __construct(protected FcmMessageService $fcmMessageService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(FcmMessagesDatatable $dataTable)
    {
        $withRelations = [];
        $filters = [];
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.marketing.fcm-message.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $flags = FcmEventsNames::$FLAGS;
        $fcm_channels = FcmEventsNames::$CHANNELS;
        $triggers = FcmEventsNames::$EVENTS;
        return view('dashboard.marketing.create-fcm',compact('flags','fcm_channels','triggers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FcmMessageStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $this->fcmMessageService->store($data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Saved Successfully'];
            return redirect()->route('fcm-messages.index')->with('toast', $toast);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $fcmMessage = $this->fcmMessageService->find($id);
        if (!$fcmMessage)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.fcm_message_not_found')];
            return back()->with('toast', $toast);
        }
        $flags = FcmEventsNames::$FLAGS;
        $fcm_channels = FcmEventsNames::$CHANNELS;
        $triggers = FcmEventsNames::$EVENTS;
        return view('dashboard.marketing.fcm-message.edit', compact('fcmMessage','flags','fcm_channels','triggers'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FcmMessageUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->fcmMessageService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('fcm-messages.index'))->with('toast', $toast);
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
    public function destroy($id)
    {
        try {
            $result = $this->fcmMessageService->delete($id);
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
        try {
            $result = $this->fcmMessageService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
