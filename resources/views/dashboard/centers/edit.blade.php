@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.countries')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
    <li class="breadcrumb-item active">{{trans('lang.countries')}}</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>{{trans("lang.Edit_Country")}}</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="{{route('centers.update',['center' => $center->id])}}" >
                        @csrf
                        @method('PUT')
                        <div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.english_name")}}</label>
								<input name="name[en]" value="{{$center->getTranslation('name','en')}}" class="form-control @error('name.en') is-invalid @enderror" id="validationCustom01" type="text" placeholder="Slug" required="">
                                @error('name.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.arabic_name")}}</label>
								<input name="name[ar]" value="{{$center->getTranslation('name','ar')}}" class="form-control @error('name.ar') is-invalid @enderror" id="validationCustom01" type="text" placeholder="Slug" required="">
                                @error('name.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom02"> {{trans("lang.address_en")}}</label>
								<input name="address[en]" value="{{$center->getTranslation('address','en')}}" class="form-control @error('address.en') is-invalid @enderror" id="validationCustom02" type="text" placeholder="Arabic Title" required="">
                                @error('address.en')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
							<div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.address_ar")}}</label>
								<input name="address[ar]" value="{{$center->getTranslation('address','ar')}}" class="form-control @error('address.ar') is-invalid @enderror" id="validationCustom02" type="text" placeholder="English Title" required="">
								@error('address.ar')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>

                            <div class="row">
                                <div class="col">
                                  <div>
                                    <label class="form-label" for="exampleFormControlTextarea4">{{trans('lang.english_description')}}</label>
                                    <textarea name="description[en]"  class="form-control" id="exampleFormControlTextarea4" rows="3">
                                        {{$center->getTranslation('description','en')}}
                                    </textarea>
                                  </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                  <div>
                                    <label class="form-label" for="exampleFormControlTextarea4">{{trans('lang.arabic_description')}}</label>
                                    <textarea name="description[ar]"   class="form-control" id="exampleFormControlTextarea4" rows="3">
                                        {{$center->getTranslation('description','ar')}}
                                    </textarea>
                                  </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_Doctor")}}</div>
                                <select name="doctor_ids[]"  class="js-example-placeholder-multiple col-sm-12 @error('doctor_ids') is-invalid @enderror" multiple="multiple">
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
                                <select  id="country" class="form-select form-select-lg mb-3 @error('parent_id') is-invalid @enderror">
                                    <option selected>{{trans('lang.choose_country')}}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{$country->id}}">{{$country->title}}</option>
                                    @endforeach
                                </select>
                            </div>
							<div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_governorate")}}</div>
                                <select class="form-select form-select-lg mb-3" id="governorate"></select>
                            </div>
							<div class="col-md-6 mb-3">
                                <div class="col-form-label">{{trans("lang.Choose_city")}}</div>
                                <select name="location_id" value="{{$center->location_id}}"  class="form-select form-select-lg mb-3" id="city"></select>
                                @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <div class="@error('phone') is-invalid @enderror input-group input-group-air">
                                    <button class="btn btn-danger"
                                        id="DeleteRow" type="button">
                                        <i class="bi bi-trash"></i>
                                        X
                                    </button>
                                    <input type="text" name="phone[]" class="form-control @error('phone') is-invalid @enderror" id="validationCustom01">
                                </div>
                                <div id="newinput"></div>
                                <button id="rowAdder" type="button" class="btn btn-dark"> <span class="bi bi-plus-square-dotted">
                                    </span> +
                                </button>
                            </div> --}}

                            <div class="col-md-6 mb-3">
								<label for="validationCustom02">{{trans("lang.phone")}}</label>
								<input name="phone" value="{{$center->phone}}" class="form-control @error('phone') is-invalid @enderror" id="validationCustom02" type="text" placeholder="phone" required="">
								@error('phone')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.lat")}}</label>
								<input name="lat"  value="{{$center->lat}}"  class="form-control @error('lat') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lat")}}" required="">
                                @error('lat')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
							</div>
                            <div class="col-md-6 mb-3">
								<label for="validationCustom01">{{trans("lang.lng")}}</label>
								<input name="lng" value="{{$center->lng}}" class="form-control @error('lng') is-invalid @enderror" id="validationCustom01" type="text" placeholder="{{trans("lang.lng")}}" required="">
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
						<button class="btn btn-primary" type="submit">ADD country</button>
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
</script>
@endsection
