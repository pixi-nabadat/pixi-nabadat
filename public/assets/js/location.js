$(document).ready(function () {
    $("#change_location").change(function () {
         var parent_id = $(this).val();
         var filling_name = $(this).data('filling-name');
         console.log(filling_name);
        $('[name="' + filling_name + '"]').html('');
        $.ajax({
            url: '/dashboard/ajax/locations/'+parent_id,
            type: 'get',
            success: function (res) {
                if (res.data != null)
                {
                    $('[name="' + filling_name + '"]').html('<option>please select</option>');
                    $.each(res.data, function (key, value) {
                        console.log(value);
                        $('[name="' + filling_name + '"]').append('<option value="' + value
                            .id + '">' + value.title + '</option>');
                    });
                }else
                    $('[name="' + filling_name + '"]').html('<option>please select</option>');

            }
        });
    });
})
