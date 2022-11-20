<?php

namespace App\Http\Controllers;

use App\DataTables\CouponsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponUpdateRequest;
use App\Http\Requests\CouponStoreRequest;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(private CouponService $couponService)
    {

    }

    public function index(CouponsDataTable $dataTable){

        return $dataTable->render('dashboard.coupons.index');

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
        try {

            $this->couponService->store($request->validated());
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
            return redirect()->route('coupons.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return back()->with('toast', $toast);
        }
    }//end of store

    public function update(CouponUpdateRequest $request, $id): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
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

}
