<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Models\Device;
use App\Models\Invoice;
use App\QueryFilters\DevicesFilter;
use App\QueryFilters\InvoiceFilter;
use Illuminate\Database\Eloquent\Builder;

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
}
