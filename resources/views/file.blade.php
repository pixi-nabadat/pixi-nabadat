@extends('layouts.simple.master')
@section('title', 'Validation Forms')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Validation Forms</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">Form Controls</li>
<li class="breadcrumb-item active">Validation Forms</li>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header">
					<h5>ADD COUNTRY</h5>
				</div>
				<div class="card-body">
					<form class="needs-validation" novalidate="" method="POST" action="/file/upload" enctype="multipart/form-data">
                        @csrf
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="validationCustom01">File</label>
								<input name="file" class="form-control" id="validationCustom01" type="file" placeholder="Slug" required="">
								<div class="valid-feedback">Looks good!</div>
							</div>
							{{-- <div class="col-md-4 mb-3">
								<label for="validationCustom02"> Title</label>
								<input name="title" class="form-control" id="validationCustom02" type="text" placeholder="Title" required="">
								<div class="valid-feedback">Looks good!</div>
							</div> --}}
							{{-- <div class="col-md-4 mb-3">
								<label for="validationCustomUsername">Username</label>
								<div class="input-group">
									<div class="input-group-prepend"><span class="input-group-text" id="inputGroupPrepend">@</span></div>
									<input class="form-control" id="validationCustomUsername" type="text" placeholder="Username" aria-describedby="inputGroupPrepend" required="">
									<div class="invalid-feedback">Please choose a username.</div>
								</div>
							</div> --}}
						</div>
						{{-- <div class="row">
							<div class="col-md-6 mb-3">
								<label for="validationCustom03">City</label>
								<input class="form-control" id="validationCustom03" type="text" placeholder="City" required="">
								<div class="invalid-feedback">Please provide a valid city.</div>
							</div>
							<div class="col-md-3 mb-3">
								<label for="validationCustom04">State</label>
								<input class="form-control" id="validationCustom04" type="text" placeholder="State" required="">
								<div class="invalid-feedback">Please provide a valid state.</div>
							</div>
							<div class="col-md-3 mb-3">
								<label for="validationCustom05">Zip</label>
								<input class="form-control" id="validationCustom05" type="text" placeholder="Zip" required="">
								<div class="invalid-feedback">Please provide a valid zip.</div>
							</div>
						</div> --}}
						{{-- <div class="mb-3">
							<div class="form-check">
								<div class="checkbox p-0">
									<input class="form-check-input" id="invalidCheck" type="checkbox" required="">
									<label class="form-check-label" for="invalidCheck">Agree to terms and conditions</label>
								</div>
								<div class="invalid-feedback">You must agree before submitting.</div>
							</div>
						</div> --}}
						<button class="btn btn-primary" type="submit">Submit form</button>
					</form>
                    @php $fileName = 'xCiq4XdCg6yZA4YamntFxVivsZp7JUB5VmkVy5TB.jpg'; @endphp
                    <form class="needs-validation" novalidate="" method="POST" action="{{ url('file/delete/') }}" enctype="multipart/form-data">
                        @csrf
						<div class="row">
							<div class="col-md-4 mb-3">
								<label for="validationCustom01">File</label>
								<input name="path" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
								<div class="valid-feedback">Looks good!</div>
                                <input name="fileName" class="form-control" id="validationCustom01" type="text" placeholder="Slug" required="">
								<div class="valid-feedback">Looks good!</div>
							</div>
						</div>

						<button class="btn btn-primary" type="submit">Submit form</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
@endsection
