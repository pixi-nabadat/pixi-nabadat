<?php

namespace App\Http\Controllers;

use App\DataTables\CancelReasonsDataTable;
use App\Enum\FcmEventsNames;
use App\Http\Requests\CancelReasonRequest;
use App\Models\User;
use App\Services\CancelReasonService;
use App\Services\CenterService;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $users = app()->make(UserService::class)->getAll();
        $centers = $users->whereNotNull('center_id');
        $locations = app()->make(LocationService::class)->getAll(['depth'=>3]);
        $flags = FcmEventsNames::$FLAGS;
        return view('dashboard.marketing.send-fcm',compact('users','centers','locations','flags'));
    } //end of create

    public function send()
    {

    }

}
