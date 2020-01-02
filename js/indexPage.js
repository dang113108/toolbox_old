$(function () {
    $("#nav-tabContent").on('click', '.page-item.gridCase', function() {
        $(".page-item.gridCase.active").removeClass('active');
        $(this).addClass('active');
        $.ajax({
            type: 'get',
            data: {
                type : category,
                keyword : keyword,
                page : $(this).text()
            },
            url: '../ajax/ajaxGridCase.php',
            dataType: "html",
            success: function (data) {
                $("#gridDiv").remove();
                $("#gridDiv").remove();
                $("#gridBr").remove();
                $("#gridNav").remove();
                $("#nav-home").prepend(data);
            }
        });
    });

    $("#nav-tabContent").on('click', '.page-item.listCase', function() {
        $(".page-item.listCase.active").removeClass('active');
        $(this).addClass('active');
        $.ajax({
            type: 'get',
            data: {
                type : category,
                keyword : keyword,
                page : $(this).text()
            },
            url: '../ajax/ajaxListCase.php',
            dataType: "html",
            success: function (data) {
                $("#listTable").remove();
                $("#listBr").remove();
                $("#listNav").remove();
                $("#nav-profile").prepend(data);
            }
        });
    });

    $('#caseModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever');
        $.ajax({
            type: 'POST',
            data: {
                caseID : recipient
            },
            url: '../ajax/ajaxCaseDetail.php',
            dataType: "html",
            success: function (data) {
                $("#modalDiv").prepend(data);
            }
        });
    });

    $('#caseModal').on('hidden.bs.modal', function (event) {
        $("#caseDetailDiv").remove();
    });

});

function chooseType(type) {
    category = type;
    $(".page-item.gridCase.active").removeClass('active');
    $(".page-item.gridCase:first").addClass('active');
    $.ajax({
        type: 'get',
        data: {
            type : category,
            keyword : keyword,
            page : 1
        },
        url: '../ajax/ajaxGridCase.php',
        dataType: "html",
        success: function (data) {
            $("#gridDiv").remove();
            $("#gridDiv").remove();
            $("#gridBr").remove();
            $("#gridNav").remove();
            $("#nav-home").prepend(data);
        }
    });

    $(".page-item.listCase.active").removeClass('active');
    $(".page-item.listCase:first").addClass('active');
    $.ajax({
        type: 'get',
        data: {
            type : category,
            keyword : keyword,
            page : 1
        },
        url: '../ajax/ajaxListCase.php',
        dataType: "html",
        success: function (data) {
            $("#listTable").remove();
            $("#listBr").remove();
            $("#listNav").remove();
            $("#nav-profile").prepend(data);
        }
    });
}