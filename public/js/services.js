

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
            console.log(idDivResult)
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
    let start_date= $("#start_date").val('');
    let final_date= $("#final_date").val('');
    $('#dataTable').DataTable().destroy();

    fetchData();
})


function deleteRecord(obj, table, url ){
    var row = $(obj).parents('tr')[0];
    let id = table.row(row).data().id;
    // let url = '{{ route("expenses.destroy", ":id") }}';
    url = url.replace(':id', id);

    $.ajax({
        url: url,
        method: 'get',
        success: function(result){
            M.toast({html: 'Despesa exclúida com sucesso!', classes: 'green'});
            fetchData();
        }
    });
}
