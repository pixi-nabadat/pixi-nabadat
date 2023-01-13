function objectifyForm(formArray) {
    //serialize data function
    var returnArray = {};
    for (var i = 0; i < formArray.length; i++){
        returnArray[formArray[i]['name']] = formArray[i]['value'];
    }
    return returnArray;
}
const table = $(".table-data");

$('.search_datatable').on('click',function (event) {
    event.preventDefault();
    table.on('preXhr.dt',function (e,settings,data) {
        data.filters = objectifyForm($('.datatables_parameters').serializeArray());
    });
    table.DataTable().ajax.reload();
    return false ;
});

$('.reset_form_data').on('click',function (event) {
    event.preventDefault();
    table.on('preXhr.dt',function (e,settings,data) {
        $('.datatables_parameters')[0].reset();
        data.filters = [];
    });
    table.DataTable().ajax.reload();
    return false ;
});
