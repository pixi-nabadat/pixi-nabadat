<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\Center;
use App\Models\Device;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\QueryFilters\DevicesFilter;
use App\QueryFilters\InvoiceFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InvoiceService extends BaseService
{
    public function getAll(array $where_condition = [],$withRelations= [])
    {
        $invoices = $this->queryGet($where_condition,$withRelations);
        return $invoices->get();
    }

    public function queryGet(array $filters = [],$withRelations=[]): Builder
    {
        $invoice = Invoice::query()->orderBy('status','asc')->with($withRelations);
        return $invoice->filter(new InvoiceFilter($filters));
    }

    public function store(array $data = [])
    {
        $invoice = Invoice::create($data);
        if (!$invoice)
            return false;
        return $invoice;
    } //end of store

    public function find($id, $withRelation = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $invoice = Invoice::with($withRelation)->find($id);
        if ($invoice)
            return $invoice;
        return false;
    } //end of find

    public function update($id, $data)
    {
        $invoice = $this->find($id);
        if (!$invoice)
            return false ;
        $invoice->update($data);
    } //end of update

    public function settleInvoice($id): bool
    {
        $invoice = $this->find($id);
        $invoice->status = Invoice::COMEPELETED;
        return $invoice->save();
    }//end of changeStatus

    /**
     * get all center dues based on the invoice status
     * @param int id
     * @param int $status
     */
    public function getAllCenterDues(int $id, int $status)
    {
        $center = Center::find($id);
        $currentInvoice = $center->invoices->where('status', $status)->all();
        if(!$currentInvoice)
            return false;
        return $currentInvoice;
    }

    /**
     * get invoice transactions
     * @param int invoiceId
     */
    public function getInvoiceTransactions(int $invoiceId)
    {
        $invoice = Invoice::find($invoiceId);
        $invoiceTransactions = $invoice->transactions;
        if(!$invoiceTransactions)
            return false;
        return $invoiceTransactions;
    }

    /**
     * get transaction details
     * @param int transactionId
     */
    public function getTransactionDetails(int $transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if(!$transaction)
            return false;
        return $transaction;
    }

    /**
     * get customer wallet
     * @param int userId
     */
    public function getCustomerWallet(int $userId): bool|Model
    {
        $user = User::find($userId);
        $customerWallet = $user->nabadatWallet;
        if(!$customerWallet)
            return false;
        return $customerWallet;
    }
}
