

function dataTableGenerate(result){
    table = dataTable("dataTable",result)
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function fetchData(start_date, final_date){
    $.ajax({
        url: urlGetRegisters,
        method: 'get',
        dataType: 'json',
        data:{
            start_date: start_date,
            final_date: final_date,
        },
        success: function(result){
            dataTableGenerate(result)
        }
    });

    $.ajax({
        url: urlGetTotalValue,
        method: 'get',
        dataType: 'json',
        success: function(result){
            $(idDivResult).text("R$ " + result.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,"))
        }
    });
}


$(document).on("click", "#filterButton", function(e){
    e.preventDefault();
    let start_date= $("#start_date").val();
    let final_date= $("#final_date").val();
    if(start_date == "" || final_date == ""){
        M.toast({html: 'Preencha os dois campos de data, por favor!', classes: 'red'});
        return
    }
    $('#dataTable').DataTable().destroy();
    fetchData(start_date, final_date);
})

$(document).on("click", "#resetFilterButton", function(e){
    e.preventDefault();
    $("#start_date").val('');
    $("#final_date").val('');
    $('#dataTable').DataTable().destroy();

    fetchData();
})

$(document).on("click", "#dataTable .delete_icon", function(){
    let row = $(this).parents('tr')[0];
    let id = table.row(row).data().id;
    let url = urlDeleteRegister

    url = url.replace(':id', id);

    $.ajax({
        url: url,
        method: 'get',
        success: function(){
            M.toast({html: typeRegister +' excluída com sucesso!', classes: 'green'});
            fetchData();
        }
    });

});



$(document).on("click", "#addButton", function(e){
    e.preventDefault();

    if(validateForm()){
        let fd = new FormData();
        let files = $('#invoice')[0].files[0];

        fd.append('file',files);
        fd.append('short_name', $('#short_name').val());
        fd.append('date_operation', $('#date_operation').val());
        fd.append('amount', $('#amount').val());
        fd.append('description', $('#description').val());

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if($("#id").val()){
            fd.append('id', $('#id').val());
            $.ajax({
                url: urlUpdateRegister,
                method: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(){
                    M.toast({html: typeRegister +' atualizada com sucesso!', classes: 'green'});
                    fetchData();
                }});}
                else {
                    $.ajax({
                        url: urlRegister,
                        method: 'post',
                        data: fd,
                contentType: false,
                processData: false,
                success: function(){
                    M.toast({html: typeRegister +' criada com sucesso!', classes: 'green'});
                    fetchData();
                }});}
        let modal = document.getElementById("modalCreate");
        let instance = M.Modal.getInstance(modal);
        instance.close();
    }
});



