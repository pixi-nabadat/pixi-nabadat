<div class="d-flex justify-content-center">


    @php
        $status = ['Pending' => 1, 'Confirmed' => 2, 'Shipped' => 3, 'Delivered' => 4, 'Canceled' => 5];
    @endphp

    <div class="btn-group">
        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">status</button>

        <div class="dropdown-menu">

            @foreach ($status as $key => $value)
                <form action={{ route('orders.updatePaymentStatus') }} method="POST">
                    @csrf
                    <input type="hidden" name="id" value={{ $order->id }}>
                    <input type="hidden" name="value" value={{ $value }}>
                    @if ($order->payment_status < $value)
                        <button class="btn btn-success col-12 my-1" type="submit">{{ $key }}</button>
                    @endif
                </form>
            @endforeach

        </div>
    </div>

    <a href="{{ route('orders.show', $order) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye  my-2"></i>
    </a>

</div>

<script>
    $('.dropdown-toggle').dropdown('')
</script>
