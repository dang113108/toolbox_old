$(function () {

    $('#userModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever');
        $.ajax({
            type: 'POST',
            data: {
                userUID : recipient
            },
            url: 'ajax/ajaxSelectUserManage.php',
            dataType: "html",
            success: function (data) {
                $("#modalDiv").prepend(data);
            }
        });
    });

    $('#userModal').on('hidden.bs.modal', function (event) {
        $("#modalDiv").empty();
    });

});