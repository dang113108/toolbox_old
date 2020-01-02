$(function () {

    $('#loginForm').on('submit', function (e) {

        e.preventDefault();

        var x = document.getElementById("snackbar");
        x.className = x.className.replace("show", "");
        var highestTimeoutId = setTimeout(";");
        for (var k = 0 ; k < highestTimeoutId ; k++) {
            clearTimeout(k);
        }
        x.innerHTML = "登入中…";
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

        $.ajax({
            type: 'post',
            url: './ajax/ajaxLogin.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                if (data == "login success") {
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