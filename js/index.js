$(function() {
    $.ajax({
        type: 'get',
        data: {
            type : category,
            keyword : keyword
        },
        url: '../ajax/ajaxGridCase.php',
        dataType: "html",
        success: function (data) {
            $("#nav-home").prepend(data);
        }
    });

    $.ajax({
        type: 'get',
        data: {
            type : category,
            keyword : keyword
        },
        url: '../ajax/ajaxListCase.php',
        dataType: "html",
        success: function (data) {
            $("#nav-profile").prepend(data);
            $.ajax({
                type: 'get',
                url: 'footer.php',
                dataType: "html",
                success: function (data) {
                    $("#mainDiv").after(data);
                }
            });
        }
    });

    $("#addCaseBtn").on("click", function() {
        $('#addCaseNoticeModal').modal('show');
    });

    $("#agreeToAddCase").on("click", function() {
        $('#addCaseNoticeModal').modal('hide');
        $('#addCaseModal').modal('show');
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal:visible').length && $(document.body).addClass('modal-open');
    });

    $('#addCaseForm').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: './ajax/ajaxInsertCase.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                if (data == "insert success") {
                    document.location.href="caseview.php";
                } else {
                    var x = document.getElementById("snackbar");
                    x.className = x.className.replace("show", "");
                    var highestTimeoutId = setTimeout(";");
                    for (var k = 0 ; k < highestTimeoutId ; k++) {
                        clearTimeout(k);
                    }
                    x.innerHTML = data;
                    x.className = "show";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                }
            }
        });
    });

    $("#c_town").on('change', function() {
        $.ajax({
            type: 'post',
            url: 'ajax/ajaxSelectRoad.php',
            data: {
                c_town : $(this).val()
            },
            success: function (data) {
                $("#c_road").find('option').remove();
                $("#c_road").prepend(data);
            }
        });
    });

    $("#c_finish_end1").on("click", function() {
        $('#c_finish_div').hide();
    });

    $("#c_finish_end2").on("click", function() {
        $('#c_finish_div').show();
    });
});

function callEmergency(){//$c：簡訊內容 $p：手機號碼
    $.ajax({
        type: 'POST',
        data: {
            message : '我在Toolbox平台上執行案件遭遇緊急狀況，請幫我報警！',
            phoneNumber : '0919038457'
        },
        url: '../ajax/ajaxSendSMS.php',
        success: function () {
            var x = document.getElementById("snackbar");
            x.className = x.className.replace("show", "");
            var highestTimeoutId = setTimeout(";");
            for (var k = 0 ; k < highestTimeoutId ; k++) {
                clearTimeout(k);
            }
            x.innerHTML = "已傳送您的求救訊息！";
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
        }
    });
}