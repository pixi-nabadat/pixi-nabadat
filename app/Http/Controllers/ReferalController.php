<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReferalPointsRequest;
use App\Services\ReferalService;

class ReferalController extends Controller
{
    public function __construct(private ReferalService $referalService)
    {

    }

    public function getInvitationView($referalCode)
    {
        return view('referal', compact('referalCode'));
    }

}
