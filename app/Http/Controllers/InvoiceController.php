<?php

namespace App\Http\Controllers;

use App\DataTables\InvoicesDataTable;
use App\Http\Requests\SettleInvoiceRequest;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $invoiceService)
    {

    }

    public function index(InvoicesDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_invoice');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['center.user'];
        return $dataTable->with(['filters' => $filters, 'withRelations' => $withRelations])->render('dashboard.invoices.index');
    }//end of index

    public function edit($id)
    {
    }//end of edit

    public function create(Request $request)
    {

    }//end of create

    public function store()
    {

    }//end of store

    public function update(Request $request, $id)
    {

    } //end of update

    public function destroy($id)
    {

    } //end of destroy

    public function show($id)
    {
        userCan(request: $request, permission: 'view_invoice');
        $invoice = $this->invoiceService->find($id, ['center.user:id,center_id,name,phone', 'transactions.user:id,center_id,name,phone']);
        return view('dashboard.invoices.show', compact('invoice'));
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
        $invoice = Invoice::with(['center', 'transactions'])->find($id);
        $pdf = PDF::loadView('dashboard.invoices.export', ['invoice' => $invoice]);

        return $pdf->stream('document.pdf');
    }
}
