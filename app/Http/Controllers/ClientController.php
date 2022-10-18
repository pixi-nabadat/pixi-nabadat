<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(UsersDataTable $dataTable,Request $request)
    {
        $request = $request->merge(['type'=>User::CUSTOMERTYPE]); //filter Clients users
        return $dataTable->with(['filters'=>$request->all()])->render('dashboard.Clients.index');
    }

    public function create()
    {

    }
}
