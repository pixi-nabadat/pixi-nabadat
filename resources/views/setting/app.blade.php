@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.centers') }}</h3>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('lang.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('centers.index') }}">{{ trans('lang.centers') }}</a></li>
    <li class="breadcrumb-item">{{ trans('lang.add') }}</li>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="container-fluid">

            <form class="needs-validation" novalidate="" method="post" enctype="multipart/form-data"
                action="{{ route('settings.store') }}">
                @csrf
                <div class="row ">

                    <div class="col-md-12 col-lg-12 col-sm-12">
                        
                        @if(count(config('setting_fields', [])) )
                        {{-- center lat and lng and google map url --}}
                        <div class="col-lg-12 col-md-12">

                            {{-- center information --}}
                            <div class="card  col-md-12">
                                <div class="card-header py-4">
                                    <h6 class="card-titel">{{config('setting_fields.app.title') }}</h6>
                                </div>
                                <div class="card-body row">

                                    @foreach(config('setting_fields.app.elements') as $field)
                                        {{-- name_ar  --}}
                                        <div class="col-md-12 d-flex my-3">
                                            <label class="form-label col-3 " for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                                            <input name="{{ $field['name'] }}" class="{{ $field['class'] }}"
                                                id="validationCustom01" type="{{ $field['type'] }}" placeholder="{{ $field['label'] }}"
                                                required=""
                                                value="{{ old($field['name']) }}">
                                            @error($field['name'])
                                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        @endif
                       

                    </div>


                    <div class="btn-toolbar float-right mb-3" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Third group">
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.submit') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')

    <script src="{{ asset('assets/js/location.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 4; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapperr
            var fieldHTML =
                '<div class="col-md-12 d-flex my-3 child">' +
                '<label class="col-form-label col-3"></label>' +
                '<div class="input-group">' +
                '<div class="input-group-prepend">' +
                '<a href="javascript:void(0);" class="remove_button" title="remove">' +
                '<i class="fa fa-minus-circle fa-2x"></i>' +
                '</a>' +
                '</div>' +
                '<input type="text" class="form-control  @error('phone') is-invalid @enderror" name="phone[]"/></div></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).closest(".child").remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

@endsection
