@extends('layouts.simple.master')

@section('title', trans('lang.push_notifications'))

@section('breadcrumb-title')
    <h3>{{ trans('lang.push_notifications') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">{{ trans('lang.dashboard') }}</li>
    <li class="breadcrumb-item active">{{ trans('lang.push_notifications') }}</li>
@endsection

@section('content')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="needs-validation" enctype="multipart/form-data" novalidate=""
                              action="{{ route('packages.store') }}">
                            @csrf
                            <div class="row g-3">
                                {{--users  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.users') }}</div>
                                    <select id="center_id" name="users[]" class="js-example-basic-multiple col-sm-12 select2-hidden-accessible  @error('users') is-invalid @enderror">
                                        <option selected disabled>{{trans('lang.please_select_users')}}</option>
                                        <option value="all">{{trans('lang.all_users')}}</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--centers  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.centers') }}</div>
                                    <select id="center_id" name="centers[]" class="js-example-basic-multiple col-sm-12 select2-hidden-accessible  @error('centers') is-invalid @enderror">
                                        <option selected disabled>{{trans('lang.please_select_centers')}}</option>
                                        <option value="all">{{trans('lang.all_centers')}}</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->center_id }}">{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{--locations  --}}
                                <div class="col-md-12 d-flex my-3">
                                    <div class="col-form-label col-3">{{ __('lang.locations') }}</div>
                                    <select id="center_id" name="locations[]" class="js-example-basic-multiple col-sm-12 select2-hidden-accessible  @error('locations') is-invalid @enderror">
                                        <option selected disabled>{{trans('lang.please_select_locations')}}</option>
                                        <option value="all">{{trans('lang.all_locations')}}</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- fcm title --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="name_en">{{ trans('lang.title') }}</label>
                                    <input name="title" class="form-control @error('title') is-invalid @enderror"
                                           id="name_en" type="text" required>
                                    @error('title')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 card">
                                    <h4 class="form-label" for="content">{{ trans('lang.flags') }}</h4>
                                    <div class="row bg-light-dark">
                                        @foreach($flags as $key=>$flag)
                                            <div class="col-md-3 col-lg-3" style="cursor: pointer;padding: 10px;color: black" onclick="copyToClipboard('{{$flag}}')">{{$flag}}</div>
                                        @endforeach
                                    </div>

                                </div>
                                {{-- fcm content --}}
                                <div class="col-md-12">
                                    <label class="form-label" for="fcm_content">{{ trans('lang.content') }}</label>
                                    <textarea name="fcm_content" class="form-control @error('fcm_content') is-invalid @enderror" id="fcm_content" type="text" required></textarea>
                                    @error('fcm_content')
                                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button class="btn btn-primary my-3" type="submit">{{ trans('lang.send') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('script')
<script>
    function copyToClipboard(text) {
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = text; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        toastr.info('Copy to Clipboard')
    }
</script>
@endsection
