$(document).on("click", "#dataTable .viewIcon", function(e){
    var row = $(this).parents('tr')[0];
    let filePath = table.row(row).data().file_path;

    if(!filePath){
        M.toast({html: 'Esta '+ typeRegister.toLowerCase() +' não possui comprovante!', classes: 'red'});
        return
    }
    let modal = document.getElementById("modalView");
    let instance = M.Modal.getInstance(modal);
    instance.open();

    $("#invoicePicture").attr("src", urlGetInvoice + filePath);
});


$(document).on("click", "#dataTable .editIcon", function(e){
    var row = $(this).parents('tr')[0];
    let id = table.row(row).data().id;
    let url = urlShowRegister;
    url = url.replace(':id', id);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: 'get',
        success: function(result){
            let data = JSON.parse(result)[0]
            $("#short_name").val(data.short_name);
            $("#date_operation").val(data.date_operation);
            $("#amount").val(data.amount);
            $("#description").val(data.description);
            $("#id").val(data.id);
        }
    });
});
