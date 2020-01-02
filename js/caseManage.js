$(function () {
    windowHeight = $(window).height();
    $('[data-toggle="tooltip"]').tooltip();
    $("#outerDiv").css('height', windowHeight - 54 - 163 - 20);
    $("#leftDiv").css('height', windowHeight - 54 - 163 - 20);
    $("#rightDivHeader").css('height', ($("#leftDiv").height() - 20) / 20);
    $("#rightDivBody").css('height', ($("#leftDiv").height() - 20) / 1.18);
    $("#rightDivFooter").css('height', ($("#leftDiv").height() - 20) / 10);
    $("#leftDiv1").css('height', windowHeight - 54 - 163 - 20);
    $("#rightDivHeader1").css('height', ($("#leftDiv1").height() - 20) / 20);
    $("#rightDivBody1").css('height', ($("#leftDiv1").height() - 20) / 1.18);
    $("#rightDivFooter1").css('height', ($("#leftDiv1").height() - 20) / 10);
    $("#leftDiv2").css('height', windowHeight - 54 - 163 - 20);
    $("#rightDivHeader2").css('height', ($("#leftDiv2").height() - 20) / 20);
    $("#rightDivBody2").css('height', ($("#leftDiv2").height() - 20) / 1.18);
    $("#rightDivFooter2").css('height', ($("#leftDiv2").height() - 20) / 10);
    $('#caseModal').on('shown.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('whatever');
        $.ajax({
            type: 'POST',
            data: {
                caseID : recipient
            },
            url: '../ajax/ajaxCaseManageDetail.php',
            dataType: "html",
            success: function (data) {
                $("#modalDiv").prepend(data);
            }
        });
    });

    $('#caseModal').on('hidden.bs.modal', function (event) {
        $("#caseDetailDiv").remove();
    });

    $("#messageArea").keypress(function (e) {
        if(e.which == 13) {
            var caseID = $("#messageArea").data('whatever');
            var message = $("#messageArea").val();
            var messagesRef = firebase.database().ref('/messages/' + caseID);
            messagesRef.push({
                name: messageName,
                photoUrl: messageImg,
                text: message
            });
            $("#messageArea").val("");
            $.ajax({
                type: 'post',
                url: './ajax/ajaxCaseManageSelectToken.php',
                data: { caseID : caseID },
                success: function (data) {
                    $.ajax({
                        type: 'post',
                        url: 'https://fcm.googleapis.com/fcm/send',
                        beforeSend: function(request) {
                            request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                            request.setRequestHeader("Content-Type", "application/json");
                        },
                        data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[0]}),
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
                        data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[1]}),
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
                        data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[2]}),
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
                        data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[3]}),
                        error: function (jqXHR, exception) {
                            console.log(jqXHR);
                            console.log(exception);
                        }
                    });
                },
                dataType:"json"
            });
            e.preventDefault();
        }
    });

$("#messageArea1").keypress(function (e) {
    if(e.which == 13) {
        var caseID = $("#messageArea1").data('whatever');
        var message = $("#messageArea1").val();
        var messagesRef = firebase.database().ref('/messages/' + caseID);
        messagesRef.push({
            name: messageName,
            photoUrl: messageImg,
            text: message
        });
        $("#messageArea1").val("");
        $.ajax({
            type: 'post',
            url: './ajax/ajaxCaseManageSelectToken.php',
            data: { caseID : caseID },
            success: function (data) {
                $.ajax({
                    type: 'post',
                    url: 'https://fcm.googleapis.com/fcm/send',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                        request.setRequestHeader("Content-Type", "application/json");
                    },
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[0]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[1]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[2]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[3]}),
                    error: function (jqXHR, exception) {
                        console.log(jqXHR);
                        console.log(exception);
                    }
                });
            },
            dataType:"json"
        });
        e.preventDefault();
    }
});

$("#messageArea2").keypress(function (e) {
    if(e.which == 13) {
        var caseID = $("#messageArea2").data('whatever');
        var message = $("#messageArea2").val();
        var messagesRef = firebase.database().ref('/messages/' + caseID);
        messagesRef.push({
            name: messageName,
            photoUrl: messageImg,
            text: message
        });
        $("#messageArea2").val("");
        $.ajax({
            type: 'post',
            url: './ajax/ajaxCaseManageSelectToken.php',
            data: { caseID : caseID },
            success: function (data) {
                $.ajax({
                    type: 'post',
                    url: 'https://fcm.googleapis.com/fcm/send',
                    beforeSend: function(request) {
                        request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
                        request.setRequestHeader("Content-Type", "application/json");
                    },
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[0]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[1]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[2]}),
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
                    data: JSON.stringify({"notification": {"title": messageName, "body": message}, "data" : { "caseID" : caseID }, "to" : data[3]}),
                    error: function (jqXHR, exception) {
                        console.log(jqXHR);
                        console.log(exception);
                    }
                });
            },
            dataType:"json"
        });
        e.preventDefault();
    }
});

$("#caseDelIcon").on('click', function() {
    var caseID = $("#caseDelIcon").data('whatever');
    $.ajax({
        type: 'post',
        url: '../ajax/ajaxDeleteCase.php',
        data: { caseID : caseID },
        success: function (data) {
            $("#messageArea").data('whatever', '');
            $("#caseInfoIcon").data('whatever', '');
            $("#caseDelIcon").data('whatever', '');
            $("#rightDivBody").text('請選擇一個案件以便觀看。');
            $("#rightDivHeader").empty();
            $("#slideCardBody" + caseID).remove();
        }
    });
});

$("#caseDelIcon1").on('click', function() {
    var caseID = $("#caseDelIcon1").data('whatever');
    $.ajax({
        type: 'post',
        url: '../ajax/ajaxDeleteCase.php',
        data: { caseID : caseID },
        success: function (data) {
            $("#messageArea1").data('whatever', '');
            $("#caseInfoIcon1").data('whatever', '');
            $("#caseDelIcon1").data('whatever', '');
            $("#rightDivBody1").text('請選擇一個案件以便觀看。');
            $("#rightDivHeader1").empty();
            $("#slideCardBody1" + caseID).remove();
        }
    });
});

$("#caseDelIcon2").on('click', function() {
    var caseID = $("#caseDelIcon2").data('whatever');
    $.ajax({
        type: 'post',
        url: '../ajax/ajaxDeleteCase.php',
        data: { caseID : caseID },
        success: function (data) {
            $("#messageArea2").data('whatever', '');
            $("#caseInfoIcon2").data('whatever', '');
            $("#caseDelIcon2").data('whatever', '');
            $("#rightDivBody2").text('請選擇一個案件以便觀看。');
            $("#rightDivHeader2").empty();
            $("#slideCardBody2" + caseID).remove();
        }
    });
});

$("#caseApproveIcon").on('click', function() {
    var caseID = $(this).data('whatever');
    $.ajax({
        type: 'post',
        url: '../ajax/ajaxUpdateReport.php',
        data: { caseID : caseID },
        success: function (data) {
            $("#messageArea2").data('whatever', '');
            $("#caseInfoIcon2").data('whatever', '');
            $("#caseDelIcon2").data('whatever', '');
            $("#rightDivBody2").text('請選擇一個案件以便觀看。');
            $("#rightDivHeader2").empty();
            $("#slideCardBody2" + caseID).remove();
        }
    });
});

$("#caseRevertIcon").on('click', function() {
    var caseID = $(this).data('whatever');
    $.ajax({
        type: 'post',
        url: '../ajax/ajaxRevertReport.php',
        data: { caseID : caseID },
        success: function (data) {
            $("#messageArea2").data('whatever', '');
            $("#caseInfoIcon2").data('whatever', '');
            $("#caseDelIcon2").data('whatever', '');
            $("#rightDivBody2").text('請選擇一個案件以便觀看。');
            $("#rightDivHeader2").empty();
            $("#slideCardBody2" + caseID).remove();
        }
    });
});

$("#caseWarningIcon").on('click', function() {
    $("#reportDiv").empty();
    var recipient = $(this).data('whatever');
    $.ajax({
        type: 'POST',
        data: {
            caseID : recipient
        },
        url: '../ajax/ajaxCaseManageReport.php',
        dataType: "html",
        success: function (data) {
            $("#reportDiv").prepend(data);
        }
    });
    $("#reportModal").modal('show');
});

});

function showMessage(caseID, caseTitle, userName) {
    $("#rightDivHeader").text(caseTitle);
    $("#rightDivBody").empty();
    $("#messageArea").data('whatever', caseID);
    $("#caseInfoIcon").data('whatever', caseID);
    $("#caseDelIcon").data('whatever', caseID);
    var caseID = $("#messageArea").data('whatever');
    var messagesRef = firebase.database().ref('/messages/' + caseID);
    messagesRef.on('child_added', function(snapshot) {
        if (typeof(snapshot.val().imageUrl) == "undefined") {
            if (userName == snapshot.val().name) {
                $("#rightDivBody").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><div class="myMessageText">' + snapshot.val().text + '</div></div>');
            } else {
                $("#rightDivBody").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><div class="yourMessageText">' + snapshot.val().text + '</div></div>');
            }
        } else {
            if (userName == snapshot.val().name) {
                $("#rightDivBody").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            } else {
                $("#rightDivBody").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            }
        }
        var scrollHeight = $('#rightDivBody').prop("scrollHeight");
        $('#rightDivBody').animate({scrollTop:scrollHeight}, 10);
    });
}

function showMessage1(caseID, caseTitle, userName) {
    $("#rightDivHeader1").text(caseTitle);
    $("#rightDivBody1").empty();
    $("#messageArea1").data('whatever', caseID);
    $("#caseInfoIcon1").data('whatever', caseID);
    $("#caseDelIcon1").data('whatever', caseID);
    var caseID = $("#messageArea1").data('whatever');
    var messagesRef = firebase.database().ref('/messages/' + caseID);
    messagesRef.on('child_added', function(snapshot) {
        if (typeof(snapshot.val().imageUrl) == "undefined") {
            if (userName == snapshot.val().name) {
                $("#rightDivBody1").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><div class="myMessageText">' + snapshot.val().text + '</div></div>');
            } else {
                $("#rightDivBody1").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><div class="yourMessageText">' + snapshot.val().text + '</div></div>');
            }
        } else {
            if (userName == snapshot.val().name) {
                $("#rightDivBody1").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            } else {
                $("#rightDivBody1").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            }
        }
        var scrollHeight = $('#rightDivBody1').prop("scrollHeight");
        $('#rightDivBody1').animate({scrollTop:scrollHeight}, 10);
    });
}

function showMessage2(caseID, caseTitle, userName) {
    $("#rightDivHeader2").text(caseTitle);
    $("#rightDivBody2").empty();
    $("#messageArea2").data('whatever', caseID);
    $("#caseInfoIcon2").data('whatever', caseID);
    $("#caseWarningIcon").data('whatever', caseID);
    $("#caseApproveIcon").data('whatever', caseID);
    $("#caseRevertIcon").data('whatever', caseID);
    var caseID = $("#messageArea2").data('whatever');
    var messagesRef = firebase.database().ref('/messages/' + caseID);
    messagesRef.on('child_added', function(snapshot) {
        if (typeof(snapshot.val().imageUrl) == "undefined") {
            if (userName == snapshot.val().name) {
                $("#rightDivBody2").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><div class="myMessageText">' + snapshot.val().text + '</div></div>');
            } else {
                $("#rightDivBody2").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><div class="yourMessageText">' + snapshot.val().text + '</div></div>');
            }
        } else {
            if (userName == snapshot.val().name) {
                $("#rightDivBody2").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            } else {
                $("#rightDivBody2").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><img class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
            }
        }
        var scrollHeight = $('#rightDivBody2').prop("scrollHeight");
        $('#rightDivBody2').animate({scrollTop:scrollHeight}, 10);
    });
}