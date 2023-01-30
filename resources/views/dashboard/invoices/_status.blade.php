<div class="justify-content-center">
    <span class="badge {{$invoice->status == \App\Models\Invoice::PENDING ? 'badge-danger':' badge-success'}}">{{$invoice->status_text}}</span>
</div>
