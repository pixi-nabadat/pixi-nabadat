<?php

namespace App\Http\Controllers;

use App\DataTables\CancelReasonsDataTable;
use App\Enum\FcmEventsNames;
use App\Http\Requests\CancelReasonRequest;
use App\Http\Requests\FcmSendRequest;
use App\Models\User;
use App\Services\CancelReasonService;
use App\Services\CenterService;
use App\Services\LocationService;
use App\Services\PushNotificationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{

    public function __construct(protected PushNotificationService $pushNotificationService)
    {
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $users = app()->make(UserService::class)->getAll();
        $centers = $users->whereNotNull('center_id');
        $locations = app()->make(LocationService::class)->getAll(['depth'=>3]);
        $flags = FcmEventsNames::$FLAGS;
        return view('dashboard.marketing.send-fcm',compact('users','centers','locations','flags'));
    } //end of create

    public function sendFcm(FcmSendRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $users_device_token = $this->pushNotificationService->sendFcm($data);
        sendFCMToTokens($users_device_token);
        $toast = [
            'message'=>__('lang.success_operation'),
            'title'=>trans('lang.success')
        ];
        return back()->with('toast',$toast);
    }

    public function scheduleFcm()
    {

    }

}
