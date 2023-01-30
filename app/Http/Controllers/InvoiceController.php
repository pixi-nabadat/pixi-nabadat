<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\DataTables\InvoicesDataTable;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SettleInvoiceRequest;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService)
    {

    }

    public function index(InvoicesDataTable $dataTable,Request $request)
    {
        $filters = $request->filters ?? [];
        $withRelations = ['center.user'];
        return $dataTable->with(['filters'=>$filters,'withRelations'=>$withRelations])->render('dashboard.invoices.index');
    }//end of index

    public function edit($id)
    {
    }//end of edit

    public function create()
    {

    }//end of create

    public function store(CategoryRequest $request)
    {

    }//end of store

    public function update(CategoryRequest $request, $id)
    {

    } //end of update

    public function destroy($id)
    {

    } //end of destroy

    public function show($id)
    {
    } //end of show

    public function settleInvoice(SettleInvoiceRequest $request)
    {
        try {
            $result = $this->invoiceService->settleInvoice($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function export($id)
    {

    }
}
