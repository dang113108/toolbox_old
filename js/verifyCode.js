$(function () {

    if (verifyCode == '[object HTMLInputElement]') {
        verifyCode = 'NoCode';
    }
    if (verifyCode != 'NoCode') {
        $('#verifyModal').modal('show');
        $('#verifyCode').val(verifyCode);
    }

    $('#verifyForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: './ajax/ajaxVerify.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                if (data == "verify success") {
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

});