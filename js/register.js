$(function () {

    $('#registerForm').on('submit', function (e) {

        e.preventDefault();

        var x = document.getElementById("snackbar");
        x.className = x.className.replace("show", "");
        var highestTimeoutId = setTimeout(";");
        for (var k = 0 ; k < highestTimeoutId ; k++) {
            clearTimeout(k);
        }
        x.innerHTML = "註冊中…";
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

        $.ajax({
            type: 'post',
            url: './ajax/ajaxRegister.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                if (data == "register success") {
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

function showMyImage(fileInput) {
    var files = fileInput.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var imageType = /image.*/;
        if (!file.type.match(imageType)) {
            continue;
        }
        var img=document.getElementById("thumbnil");
        img.file = file;
        var reader = new FileReader();
        reader.onload = (function(aImg) {
            return function(e) {
                aImg.src = e.target.result;
            };
        })(img);
        reader.readAsDataURL(file);
    }
}

function pidtest() {
    var pid = $("#userIdentity").val();
    userIdentity = document.getElementById("userIdentity");
    if (pid.length == 10) {
        if (pidsex(pid)) {
            var num = new Array(10, 11, 12, 13, 14, 15, 16, 17, 34, 18, 19, 20, 21, 22, 35, 23, 24, 25, 26, 27, 28, 29, 32, 30, 31, 33);
            var en = pid.substr(0, 1);
            en = num[en.charCodeAt() - 65];
            en = Number(String(en).substr(0, 1)) + Number(String(en).substr(1, 1)) * 9;
            for (var i = 8; i > 0; i--) {
                en += Number(pid.substr((9 - i), 1)) * i;
            }
            en += Number(pid.substr(9, 1));
            if (en % 10 == 0) {
                userIdentity.setCustomValidity('');
                return true;
            } else {
                userIdentity.setCustomValidity('身分證輸入有誤，請檢查');
                return false;
            }
        } else {
            userIdentity.setCustomValidity('身分證輸入有誤，請檢查');
            return false;
        }
    } else {
        userIdentity.setCustomValidity('長度應為10碼，請檢查');
        return false;
    }
}

function pidsex(pid) {
    var sex = pid.substr(1, 1);
    if (sex == 1) {
        sex = "男性";
    } else if (sex == 2) {
        sex = "女性";
    } else {
        sex = false;
        return sex;
    }
    document.getElementById("userSex").value = sex;
    return sex;
}