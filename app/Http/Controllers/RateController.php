<?php

namespace App\Http\Controllers;

use App\DataTables\RatesDatatable;
use App\Models\Rate;
use App\Services\RateService;
use Illuminate\Http\Request;

class RateController extends Controller
{

    public function __construct(private RateService $rateService)
    {
    }

    public function index(RatesDatatable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_rate');
        $loadRelation = ['ratable'];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.rates.index');
    } //end of index

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_rate');
        $rate = Rate::find($id);
        return view('dashboard.rates.show', compact('rate'));
    } //end of show

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_rate');
        try {
            $result = $this->rateService->destroy($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function status(Request $request)
    {
        try {
            $result = $this->rateService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
