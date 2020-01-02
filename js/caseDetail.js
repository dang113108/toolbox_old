$(function() {
    $("#ratyResult").hide();
    $('#rating').raty({
        hints: ['1', '2', '3', '4', '5'],
        path: "../img/raty",
        starOff: 'star-off-big.png',
        starOn: 'star-on-big.png',
        size: 24,
        target: '#ratyResult',
        targetKeep : true
    });
    var askIsHide = true;
    var getIsHide = true;
    var ratyIsHide = true;
    var repoIsHide = true;
    $("#askBtn").on("click", function() {
        if (askIsHide == true) {
            repoIsHide = true;
            $("#reportDiv").slideUp();
            getIsHide = true;
            $("#getDiv").slideUp();
            askIsHide = false;
            $("#qnaDiv").slideDown();
        } else {
            askIsHide = true;
            $("#qnaDiv").slideUp();
        }
    });

    $("#getBtn").on("click", function() {
        if (getIsHide == true) {
            repoIsHide = true;
            $("#reportDiv").slideUp();
            askIsHide = true;
            $("#qnaDiv").slideUp();
            getIsHide = false;
            $("#getDiv").slideDown();
        } else {
            getIsHide = true;
            $("#getDiv").slideUp();
        }
    });
    $("#ratingToCheck").on("click", function() {
        if (ratyIsHide == true) {
            repoIsHide = true;
            $("#reportDiv").slideUp();
            ratyIsHide = false;
            $("#ratyDiv").slideDown();
        } else {
            ratyIsHide = true;
            $("#ratyDiv").slideUp();
        }
    });
    $("#repBtn").on("click", function() {
        if (repoIsHide == true) {
            ratyIsHide = true;
            $("#ratyDiv").slideUp();
            getIsHide = true;
            $("#getDiv").slideUp();
            askIsHide = true;
            $("#qnaDiv").slideUp();
            repoIsHide = false;
            $("#reportDiv").slideDown();
        } else {
            repoIsHide = true;
            $("#reportDiv").slideUp();
        }
    });

    $('#questionForm').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'ajax/ajaxInsertQuestion.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                $("#question").val("");
                askIsHide = true;
                $("#qnaDiv").slideUp();
                $("#qnaTable").prepend(data);
            }
        });

    });

    $('#getCaseForm').on('submit', function (e) {
        var caseID = $("#getCaseID").val();
        var postID = $("#getPostID").val();
        e.preventDefault();

        $.ajax({
            type: 'post',
            url: 'ajax/ajaxInsertGetCase.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                if (data == "Insert Success!") {
                    $("#getBtn").attr('disabled', true);
                    getIsHide = true;
                    $("#getDiv").slideUp();
                }
            }
        });

        $.ajax({
            type: 'post',
            url: 'https://a238c12f.ngrok.io/send_lineNotify',
            beforeSend: function(request) {
                request.setRequestHeader("Content-Type", "application/json");
            },
            data: JSON.stringify({"caseID": caseID, "account": postID, "type": 'case_someone_apply'}),
            dataType : 'json'
        });

    });

    $('#ratyForm').on('submit', function (e) {
        var caseID = $("#ratyCaseID").val();
        var postID = $("#ratytPostID").val();
        var reciID = $("#ratytReciID").val();
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'ajax/ajaxInsertRating.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                $("#ratingToCheck").attr('disabled', true);
                getIsHide = true;
                $("#ratyDiv").slideUp();
                if (data == "評價更新成功！") {
                    $("#caseStatus").text("此案件已經完成。");
                    $.ajax({
                        type: 'post',
                        url: 'https://a238c12f.ngrok.io/send_lineNotify',
                        beforeSend: function(request) {
                            request.setRequestHeader("Content-Type", "application/json");
                        },
                        data: JSON.stringify({"caseID": caseID, "account": postID + "," + reciID, "type": 'case_finish'}),
                        dataType : 'json'
                    });
                }
            }
        });

    });

    $('#colBtn').on('click', function () {
        var status = $("#colText").text();
        $.ajax({
            type: 'post',
            url: 'ajax/ajaxInsertCollect.php',
            data: {
                userID : userID,
                caseID : caseID,
                status : status
            },
            success: function (data) {
                $("#colText").text(data);
                if (data == "收藏") {
                    data = "取消收藏成功！";
                } else if (data == "取消") {
                    data = "收藏成功！";
                }
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
        });

    });

    $('#reportForm').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type: 'post',
            url: '../ajax/ajaxInsertReport.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function (data) {
                $("#repBtn").attr('disabled', true);
                $("#reportContent").val("");
                repoIsHide = true;
                $("#reportDiv").slideUp();
            }
        });

    });

    $("#chooseCard").on("click", ".chooseToolMan" , function() {
        var m_mid = $(this).attr("data-msgId");
        var caseID = $(this).attr("data-caseId");
        var taskerID = $(this).attr("data-taskerId");
        var statusImg = "../img/keeping.png";
        $.ajax({
            type: 'post',
            url: 'ajax/ajaxUpdateGetCase.php',
            data: {
                m_mid : m_mid
            },
            success: function (data) {
                if (data != "選擇失敗！請重新再試") {
                    $("#chooseCard").hide();
                    $("#caseStatus").text("等待接案人完成中。");
                    $("#slidePostStatus" + data['c_cid']).attr("src", statusImg);
                    $("#listStatusImg" + data['c_cid']).attr("src", statusImg);
                    $("#gridStatusDiv" + data['c_cid']).text("進行中");
                    $("#gridStatusDiv" + data['c_cid']).toggleClass('waiting keeping');
                    $.ajax({
                        type: 'post',
                        url: 'https://a238c12f.ngrok.io/send_lineNotify',
                        beforeSend: function(request) {
                            request.setRequestHeader("Content-Type", "application/json");
                        },
                        data: JSON.stringify({"caseID": caseID, "account": taskerID, "type": 'case_taker'}),
                        dataType : 'json'
                    });
                    $.ajax({
                        type: 'post',
                        url: './ajax/ajaxGetWastaked.php',
                        data : {
                            caseID : caseID,
                            taskerID : taskerID
                        },
                        success: function(data) {
                            $.ajax({
                                type: 'post',
                                url: 'https://a238c12f.ngrok.io/send_lineNotify',
                                beforeSend: function(request) {
                                    request.setRequestHeader("Content-Type", "application/json");
                                },
                                data: JSON.stringify({"caseID": caseID, "account": data, "type": 'case_wastaked'}),
                                dataType : 'json'
                            });
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: 'ajax/ajaxUpdateSlideMessage.php',
                        data: {
                            caseID : data['c_cid'],
                            category : data['c_category'],
                            title : data['c_title'],
                            money : data['c_money'],
                            address : data['c_city'] + data['c_town'] + data['c_road']
                        },
                        success: function (data) {
                            $("#slideMessageDiv").prepend(data);
                        }
                    });
                    var messagesRef = firebase.database().ref('/messages/' + data['c_cid']);
                    messagesRef.push({
                        name: 'ToolBox',
                        photoUrl: 'https://i.imgur.com/4tZlBEC.png',
                        text: '開始對話！'
                    });
                    $.ajax({
                        type: 'post',
                        url: './ajax/ajaxSelectToken.php',
                        data: { caseID : data['c_cid'] },
                        success: function (data) {
                            $.ajax({
                                type: 'post',
                                url: 'https://fcm.googleapis.com/fcm/send',
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                                    request.setRequestHeader("Content-Type", "application/json");
                                },
                                data: JSON.stringify({"notification": {"title": "ToolBox", "body": "開始對話吧！"}, "data" : { "caseID" : data[2] }, "to" : data[0]}),
                                error: function (jqXHR, exception) {
                                    console.log(jqXHR);
                                    console.log(exception);
                                }
                            });
                            $.ajax({
                                type: 'post',
                                url: 'https://fcm.googleapis.com/fcm/send',
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                                    request.setRequestHeader("Content-Type", "application/json");
                                },
                                data: JSON.stringify({"notification": {"title": "ToolBox", "body": "開始對話吧！"}, "data" : { "caseID" : data[2] }, "to" : data[1]}),
                                error: function (jqXHR, exception) {
                                    console.log(jqXHR);
                                    console.log(exception);
                                }
                            });
                        },
                        dataType:"json"
                    });
                    $.ajax({
                        type: 'post',
                        url: './ajax/ajaxSelectMyToken.php',
                        data: { caseID : data['c_cid'] },
                        success: function (data) {
                            $.ajax({
                                type: 'post',
                                url: 'https://fcm.googleapis.com/fcm/send',
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                                    request.setRequestHeader("Content-Type", "application/json");
                                },
                                data: JSON.stringify({"notification": {"title": "ToolBox", "body": "開始對話吧！"}, "data" : { "caseID" : data[2] }, "to" : data[0]}),
                                error: function (jqXHR, exception) {
                                    console.log("這裡錯了");
                                    console.log(jqXHR);
                                    console.log(exception);
                                }
                            });
                            $.ajax({
                                type: 'post',
                                url: 'https://fcm.googleapis.com/fcm/send',
                                beforeSend: function(request) {
                                    request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                                    request.setRequestHeader("Content-Type", "application/json");
                                },
                                data: JSON.stringify({"notification": {"title": "ToolBox", "body": "開始對話吧！"}, "data" : { "caseID" : data[2] }, "to" : data[1]}),
                                error: function (jqXHR, exception) {
                                    console.log("這裡錯了2");
                                    console.log(jqXHR);
                                    console.log(exception);
                                }
                            });
                        },
                        dataType:"json"
                    });
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
            },
            dataType:"json"
        });
});

$("#qnaTable").on("click", ".answerBtn" , function() {
    var q_qid = $(this).attr("data-qid");
    var q_atext = $("#answer" + q_qid).val();
    $.ajax({
        type: 'post',
        url: 'ajax/ajaxInsertAnswer.php',
        data: {
            q_qid : q_qid,
            q_atext : q_atext
        },
        success: function (data) {
            $("#answerIcon" + q_qid).html('<i class="fas fa-user-check qnaAnswered sameline"></i>');
            $("#answerDiv" + q_qid).before(data);
            $("#answerDiv" + q_qid).empty();
        }
    });
});

$("#askToCheck").on("click", function() {
    var c_cid = $(this).attr("data-cid");
    var c_pid = $(this).attr("data-pid");
    var c_status = $(this).attr("data-status");
    $.ajax({
        type: 'post',
        url: 'ajax/ajaxUpdateCase.php',
        data: {
            caseID : c_cid,
            c_status : c_status
        },
        success: function (data) {
            if (data == "更新成功") {
                $("#askToCheck").attr('disabled', true);
                $("#caseStatus").text("等待發案人確認中。");
                $.ajax({
                    type: 'post',
                    url: 'https://a238c12f.ngrok.io/send_lineNotify',
                    beforeSend: function(request) {
                        request.setRequestHeader("Content-Type", "application/json");
                    },
                    data: JSON.stringify({"caseID": c_cid, "account": c_pid, "type": 'case_confirm'}),
                    dataType : 'json'
                });
            }
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
    });
});

$("#overToCheck").on("click", function() {
    var c_cid = $(this).attr("data-cid");
    var c_pid = $(this).attr("data-pid");
    var c_rid = $(this).attr("data-rid");
    var c_status = $(this).attr("data-status");
    $.ajax({
        type: 'post',
        url: 'ajax/ajaxUpdateCase.php',
        data: {
            caseID : c_cid,
            c_status : c_status
        },
        success: function (data) {
            if (data == "更新成功") {
                $("#overToCheck").attr('disabled', true);
                $("#reverToCheck").attr('disabled', true);
                $("#ratingToCheck").attr('disabled', false);
                $("#caseStatus").text("等待雙方評價案件中。");
                $.ajax({
                    type: 'post',
                    url: 'https://a238c12f.ngrok.io/send_lineNotify',
                    beforeSend: function(request) {
                        request.setRequestHeader("Content-Type", "application/json");
                    },
                    data: JSON.stringify({"caseID": c_cid, "account": c_pid, "type": 'case_score'}),
                    dataType : 'json'
                });
                $.ajax({
                    type: 'post',
                    url: 'https://a238c12f.ngrok.io/send_lineNotify',
                    beforeSend: function(request) {
                        request.setRequestHeader("Content-Type", "application/json");
                    },
                    data: JSON.stringify({"caseID": c_cid, "account": c_rid, "type": 'case_score'}),
                    dataType : 'json'
                });

            }
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
    });
});

$("#reverToCheck").on("click", function() {
    var c_cid = $(this).attr("data-cid");
    var c_status = $(this).attr("data-status");
    $.ajax({
        type: 'post',
        url: 'ajax/ajaxUpdateCase.php',
        data: {
            caseID : c_cid,
            c_status : c_status
        },
        success: function (data) {
            if (data == "更新成功") {
                $("#reverToCheck").attr('disabled', true);
                $("#overToCheck").attr('disabled', true);
                $("#caseStatus").text("等待接案人完成中。");
            }
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
    });
});
});