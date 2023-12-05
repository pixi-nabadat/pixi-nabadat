<?php

namespace App\Http\Controllers;

use App\DataTables\ReservationDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationStoreRequest as ReservationUpdateRequest;
use App\Services\CenterService;
use App\Services\ReservationService;
use App\Services\UserService;
class ReservationController extends Controller
{
    public function __construct(private ReservationService $reservationService, private CenterService $centerService, private UserService $userService)
    {
    }

    public function index(Request $request,ReservationDataTable $dataTable)
    {
        userCan(request: $request, permission: 'view_reservation');
        $withRelations = ['user','center'];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.reservations.index');
    }
    
    public function edit(Request $request, $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        userCan(request: $request, permission: 'edit_reservation');
        $withRelation = ['center', 'user'];
        $reservation = $this->reservationService->findById($id,$withRelation);
        if (!$reservation)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.reservation_not_found')];
            return back()->with('toast', $toast);
        }
        $centers = $this->centerService->getAll();
        $users = $this->userService->getAll();
        $centerDevices = $reservation->center->devices;
        return view('dashboard.reservations.edit', compact(['centers', 'reservation', 'users', 'centerDevices']));

    } //end of edit

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_reservation');
        $centers = $this->centerService->getAll();
        $users_filter = ['type'=>User::CUSTOMERTYPE];
        $users = $this->userService->getAll(where_condition: $users_filter);
        return view('dashboard.reservations.create', compact(['centers', 'users']));
    } //end of create

    public function store(ReservationStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        userCan(request: $request, permission: 'create_reservation');
        try {
            $data = $request->validated();
            $this->reservationService->store($data);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
            return redirect()->route('reservations.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(ReservationUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_reservation');
        try {
            $data = $request->validated();
            $this->reservationService->update($id, $data);
            $toast = ['title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
            return redirect(route('reservations.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_reservation');
        try {
            $result = $this->reservationService->destroy($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_reservation');
        $withRelation = ['center','user'];
        $reservation = $this->reservationService->findById(id: $id, with: $withRelation);
        if (!$reservation) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.reservation_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.reservations.show', compact('reservation'));
    } //end of show
}