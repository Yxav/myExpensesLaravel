document.addEventListener('DOMContentLoaded', function() {
    let elems = document.querySelectorAll('.modal');
    M.Modal.init(elems, {});
  });

$(document).ready(function(){
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
});


$(document).ready(function () {
    $("html").on("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $("html").on("drop", function (e) {
        e.preventDefault();
        e.stopPropagation();
    });

    $('#drag_and_drop').on('dragover', function () {
        $(this).addClass('drag_over');
        return false;
    });

    $('#drag_and_drop').on('dragleave', function () {
        $(this).removeClass('drag_over');
        return false;
    });

    $('#drag_and_drop').on('drop', function (e) {
        e.preventDefault();
        let fileInput = document.querySelector('input[type="file"]');
        $(this).removeClass('drag_over');
            let files = e.originalEvent.dataTransfer.files;
            const dT = new DataTransfer();
            dT.items.add(files[0]);
            fileInput.files = dT.files;
        });
    })
