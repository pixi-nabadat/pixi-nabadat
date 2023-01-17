<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function index(UsersDataTable $dataTable, Request $request)
    {
        $withRelations = ['location:id,title'];
        $filters = $request->filters ?? [];
        $filters = array_merge($filters , ['type'=>User::CUSTOMERTYPE]);
        return $dataTable->with(['filters' => $filters, 'withRelations' => $withRelations])->render('dashboard.users.index');
    }

    public function create()
    {

    }

    public function show(int $id)
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }

    public function status(Request $request)
    {
        try {
            $result = $this->userService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
