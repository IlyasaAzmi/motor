$(document).ready(function () {

    $(document).on('click', '#modal-btn-pop-up', function (e) {
    var url = $(this).attr("href");
    $("#modalform").modal("show").find("#modalContent").load(url);
    // $('.modal-title').text(" $this-&gt;title ");
    e.preventDefault();
    });

});
