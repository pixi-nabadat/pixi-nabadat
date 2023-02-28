<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceResource;
use App\Http\Resources\InvoiceTransactionsResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use Exception;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * get center dues and nabadat dues for custom center
     * @param int $id //center id
     */
    public function getAllCenterDues(int $id)
    {
        try{
            $currentInvoice = $this->invoiceService->getAllCenterDues(id: $id, status: Invoice::PENDING);
            if(!$currentInvoice)
                return apiResponse(message: trans('lang.not_found'), code: 422);
            $response =  FinanceResource::collection($currentInvoice);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }

    }

    /**
     * get center dues for all completed invoices and nabadat dues for custom center
     * @param int $id //center id
     */
    public function getAllCenterDuesHistory(int $id)
    {
        try{
            $currentInvoice = $this->invoiceService->getAllCenterDues(id: $id, status: Invoice::COMEPELETED);
            if(!$currentInvoice)
                return apiResponse(message: trans('lang.not_found'), code: 422);
            $response = FinanceResource::collection($currentInvoice);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }

    }

    /**
     * get invoice transactions
     * @param int $id //invoice id
     */
    public function getInvoiceTransactions(int $id)
    {
        try{
            $invoiceTransactions = $this->invoiceService->getInvoiceTransactions(invoiceId: $id);
            if(!$invoiceTransactions)
                return apiResponse(message: trans('lang.not_found'), code: 422);
            $response = InvoiceTransactionsResource::collection($invoiceTransactions);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
        }catch(Exception $e){
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }
    }
}
