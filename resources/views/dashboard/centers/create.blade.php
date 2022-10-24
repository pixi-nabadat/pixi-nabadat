@extends('layouts.simple.master')
@section('title', trans('lang.centers'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.centers') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{trans('lang.dashboard')}}</a></li>
    <li class="breadcrumb-item"><a href="{{route('centers.index')}}">{{trans('lang.centers')}}</a></li>
    <li class="breadcrumb-item">{{trans('lang.add')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="post" action="{{route('centers.store')}}" >
                        @csrf
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.english_name")}}</label>
								<input name="name[en]" class="form-control @error('name.en') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.english_name")}}" required="">
                                @error('name.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.arabic_name")}}</label>
								<input name="name[ar]" class="form-control @error('name.ar') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.arabic_name")}}" required="">
                                @error('name.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.address_en")}}</label>
								<input name="address[en]" class="form-control @error('address.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="{{trans("lang.address_en")}}" required="">
                                @error('address.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.address_ar")}}</label>
								<input name="address[ar]" class="form-control @error('address.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="{{trans("lang.address_ar")}}" required="">
								@error('address.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>

                            <div class="row">
                                <div class="col">
                                  <div>
                                    <label class="form-label" for="exampleFormControlTextarea4">{{trans('lang.english_description')}}</label>
                                    <textarea name="description[en]" class="form-control" id="exampleFormControlTextarea4" rows="3"></textarea>
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                  <div>
                                    <label class="form-label" for="exampleFormControlTextarea4">{{trans('lang.arabic_description')}}</label>
                                    <textarea name="description[ar]" class="form-control" id="exampleFormControlTextarea4" rows="3"></textarea>
                                  </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_Doctor")}}</div>
                                <select name="doctor_ids[]" class="js-example-placeholder-multiple col-sm-12 @error('doctor_ids') is-invalid @enderror" multiple="multiple">
                                    {{-- @foreach ($currencies as $currency) --}}
                                    <option value="1">Yoins</option>
                                    <option value="2">Zain</option>
                                    <option value="3">Omar</option>
                                    <option value="4">Belal</option>
                                    {{-- @endforeach --}}
                                </select>
                                @error('doctor_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                            </div>

							<div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_Country")}}</div>
                                <select  id="country" class="form-select form-control mb-3 @error('parent_id') is-invalid @enderror" >
                                    <option selected value="">{{trans('lang.choose_country')}}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                            </div>
							<div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.Governorate")}}</div>
                                <select class="form-select form-control mb-3" id="governorate"></select>
                            </div>
							<div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.City")}}</div>
                                <select name="location_id" class="form-select form-control mb-3 @error('location_id') is-invalid @enderror" id="city"></select>
                                @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.phone")}}</label>
								<input name="phone" class="form-control @error('phone') is-invalid @enderror" id="validationCustom02" type="text" placeholder="phone" required="">
								@error('phone')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>

                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.lat")}}</label>
								<input name="lat" class="form-control @error('lat') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lat")}}" required="">
                                @error('lat')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.lng")}}</label>
								<input name="lng" class="form-control @error('lng') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lng")}}" required="">
                                @error('lng')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>

                            <div class="mb-3">
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{trans('lang.is_active')}}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_active" value="1" checked=""><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="media mb-2">
                                    <label class="col-form-label m-r-10">{{trans('lang.is_support_auto_service')}}</label>
                                    <div class="media-body  icon-state">
                                        <label class="switch">
                                            <input type="checkbox" name="is_support_auto_service" value="1" checked=""><span class="switch-state"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
						<button class="btn btn-primary" type="submit">{{trans("lang.submit")}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')

<script type="text/javascript">
    $(document).ready(function () {
        $('#country').on('change', function () {
            var countryId = this.value;
            $('#governorate').html('');
            $.ajax({
                url: '{{ route('allGovernorates') }}?country_id='+countryId,
                type: 'get',
                success: function (res) {
                    $('#governorate').html('<option value="">Select Governorate</option>');
                    $.each(res, function (key, value) {
                        $('#governorate').append('<option value="' + value
                            .id + '">' + value.title['en'] + '</option>');
                    });
                    $('#city').html('<option value="">Select City</option>');
                }
            });
        });
        $('#governorate').on('change', function () {
                var governorateId = this.value;
                $('#city').html('');
                $.ajax({
                    url: '{{ route('allGovernorates') }}?country_id='+governorateId,
                    type: 'get',
                    success: function (res) {
                        $('#city').html('<option value="">Select City</option>');
                        $.each(res, function (key, value) {
                            $('#city').append('<option value="' + value
                                .id + '">' + value.title['en'] + '</option>');
                        });
                    }
                });
        });
    });

    $("#rowAdder").click(function () {
            newRowAdd =
            '<div id="row"> <div class=" input-group input-group-air">' +
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i> X </button> </div>' +
            '<input type="text" class="form-control"> </div> </div>';

            $('#newinput').append(newRowAdd);
        });

        $("body").on("click", "#DeleteRow", function () {
            $(this).parents("#row").remove();
        })
</script>

@endsection
