<!DOCTYPE html>
<html>
<head>
    <title>Dependent dropdown example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="m-5 w-50">
        <h1 class="lead">Dependent dropdown example</h1>
        <div class="mb-3">
            <select class="form-select form-select-lg mb-3" id="country">
                <option selected disabled>Select country</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select class="form-select form-select-lg mb-3" id="state"></select>
        </div>
        <div class="mb-3">
            <select class="form-select form-select-lg mb-3" id="city"></select>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#country').on('change', function () {
                var countryId = this.value;
                $('#state').html('');
                $.ajax({
                    url: '{{ route('getcovernorates') }}?country_id='+countryId,
                    type: 'get',
                    success: function (res) {
                        $('#state').html('<option value="">Select State</option>');
                        $.each(res, function (key, value) {
                            $('#state').append('<option value="' + value
                                .id + '">' + value.title + '</option>');
                        });
                        $('#city').html('<option value="">Select City</option>');
                    }
                });
            });

        });
    </script>
    <script src="{{asset('assets/js/form-validation-custom.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
