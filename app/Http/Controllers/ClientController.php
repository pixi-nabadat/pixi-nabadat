<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Models\User;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct(protected UserService $userService, private LocationService $locationService)
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
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.users.create', compact('governorates'));
    }

    public function show(int $id)
    {
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

    public function edit($id)
    {
        $withRelation = ['attachments'];
        $client = $this->userService->find($id,$withRelation);
        if (!$client) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.patient_not_found')];
            return back()->with('toast', $toast);
        }
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.users.edit', compact('client', 'governorates'));
    }

    public function update(ClientUpdateRequest $request, $id)
    {
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

    public function destroy($id)
    {
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
        try {
            $data = $request->validated();
            $this->userService->store(data: $data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('success_operation')];
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
