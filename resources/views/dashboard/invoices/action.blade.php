<div class="d-flex justify-content-center">

    @can('view_invoice')
    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn-sm btn-info me-1">
        <i class="fa fa-eye my-2"></i>
    </a>
    @endcan

    
    @if($invoice->transactions->count())
        <a href="{{ route('invoices.export-pdf', $invoice->id) }}" class="btn-sm btn-primary me-1">
            <i class="fa fa-file-pdf-o my-2"></i>
        </a>
    @endif

    @if($invoice->status == \App\Models\Invoice::PENDING)
        <button role="button" onclick="settleInvoice('{{ route('invoices.settle')}}','{{$invoice->id}}')"
            class="btn btn-success">collect
        </button>
    @endif
</div>
