<?php

namespace App\Http\Controllers;

use App\DataTables\CouponsDataTable;
use App\Events\PushEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponUpdateRequest;
use App\Http\Requests\CouponStoreRequest;
use App\Models\FcmMessage;
use App\Models\User;
use App\Services\CouponService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(private CouponService $couponService)
    {

    }

    public function index(CouponsDataTable $dataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $employees = User::where('type', User::SUPERADMINTYPE)->orWhere('type', User::EMPLOYEE)->get();
        return $dataTable->with(['filters'=>$filters])->render('dashboard.coupons.index', ['employees'=>$employees]);

    }//end of index

    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $coupon = $this->couponService->find($id);
        if (!$coupon)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.coupon_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.coupons.edit', compact('coupon'));
    }//end of edit

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('dashboard.coupons.create');
    }//end of create

    public function store(CouponStoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        //first forget cash
       $data = $request->validated();
       $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
       $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');
        try {
            $coupon = $this->couponService->store($data);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
            event(new PushEvent($coupon,FcmMessage::CREATE_NEW_COUPON_DISCOUNT));
            return redirect()->route('coupons.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
        }
    }//end of store

    public function update(CouponUpdateRequest $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        //first forget cash
        try {
            $this->couponService->update($id,  $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('coupons.index'))->with('toast', $toast);
        } catch (\Exception $ex) {
            
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        //first forget cash
        try {
            $result = $this->couponService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $coupon = $this->couponService->find($id);
        if (!$coupon)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.coupon_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.coupons.show', compact('coupon'));
    } //end of show

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * status method for change is_active column only
     */
    public function status(Request $request)
    {
        try {
            $result = $this->couponService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status

}
