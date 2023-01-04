<div class="d-flex justify-content-center">

    @php
        $status = ['pending' => 1, 'confirmed' => 2, 'shipped' => 3, 'delivered' => 4, 'canceled' => 5];
    @endphp

    <div class="btn-group">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
            aria-expanded="false">{{ __('lang.status') }} </button>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">

            @foreach ($status as $key => $value)
                <form action={{ route('orders.updateOrderStatus') }} method="POST">
                    @csrf
                    <input type="hidden" name="id" value={{ $order->id }}>
                    <input type="hidden" name="value" value={{ $value }}>
                    <li><button class="btn text-dark bg-witht col-12 my-1 dropdown-item" type="submit">
                            {{ __('lang' . '.' . $key) }}</button></li>
                </form>
            @endforeach

        </ul>
    </div>

    <a href="{{ route('orders.show', $order) }}" class="btn-sm btn-primary me-1">
        <i class="fa fa-eye my-2"></i>
    </a>

</div>
