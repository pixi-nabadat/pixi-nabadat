<div class="justify-content-center">
    <ul>
        <li>primary:{{$center->user->phone}}</li>
        @if(count($center->phones))
            @foreach($center->phones as $phone)
                <li>{{$phone}}</li>
            @endforeach
        @endif
    </ul>

</div>
