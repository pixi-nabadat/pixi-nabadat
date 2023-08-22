function objectifyForm(formArray) {
    //serialize data function
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
const table = $(".table-data");

$(document).on('click','.search_datatable',function (event) {
    event.preventDefault();
    var filters = $('.datatables_parameters').serializeArray();
    table.on('preXhr.dt',function (e,settings,data) {
        data.filters = objectifyForm(filters);
    });
    table.DataTable().ajax.reload();
    return false ;
});

$(document).on('click','.reset_form_data',function (event) {
    event.preventDefault();
    $('.datatables_parameters')[0].reset();
    table.on('preXhr.dt',function (e,settings,data) {
        data.filters = [];
    });
    table.DataTable().ajax.reload();
    return false ;
});
