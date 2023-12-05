<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Exceptions\NotFoundException;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\Location;
use App\Models\User;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Mockery\Exception;

class ClientController extends Controller
{
    public function __construct(protected UserService $userService, private LocationService $locationService)
    {
    }

    public function index(UsersDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_client');
        $withRelations = ['location:id,title'];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $filters = array_merge($filters , ['type'=>User::CUSTOMERTYPE]);
        $governorateFilters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($governorateFilters);
        return $dataTable->with(['filters' => $filters, 'withRelations' => $withRelations])->render('dashboard.users.index', ['governorates'=>$governorates]);
    }

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_client');
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.users.create', compact('governorates'));
    }

    public function show(Request $request, int $id)
    {
        userCan(request: $request, permission: 'view_client');
        $withRelations = ['attachments'];
        $client = $this->userService->find($id, $withRelations);
        if (!$client) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.patient_not_found')];
            return back()->with('toast', $toast);
        }
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.users.show', compact('client','governorates'));
    }

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_client');
        try {
            $withRelation = ['attachments','location'];
            $client = $this->userService->find($id,$withRelation);
            $governorates = $this->locationService->getAll(['depth' => 1, 'is_active' => 1]);
            return view('dashboard.users.edit', compact('client', 'governorates'));

        }catch (Exception|NotFoundException $exception)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.patient_not_found')];
            return back()->with('toast', $toast);
        }
    }

    public function update(ClientUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_client');
        try {
            $data = $request->validated();
            $this->userService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('clients.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_client');
        try {
            $result = $this->userService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function store(ClientStoreRequest $request)
    {
        userCan(request: $request, permission: 'create_client');
        try {
            $data = $request->validated();
            $this->userService->store(data: $data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('clients.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store
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
