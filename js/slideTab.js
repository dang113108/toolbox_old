$(function(){
	var postCanvas = document.getElementById("postCanvas").getContext('2d');
	var getCanvas = document.getElementById("getCanvas").getContext('2d');
	var pinSlideTab = true;
	var cID = 0;
	var w = $("#mwt_slider_content").width();
	var wMode = "Top";
	showSlideRatyPost("");
	showSlideRatyGet("");
	$('#mwt_slider_content').css('height', $(window).height());

	$("#mwt_fb_tab").mouseover(function(){
		if (pinSlideTab) {
			if ($("#mwt_mwt_slider_scroll").css('left') == '-'+w+'px')
			{
				wMode = "Top";
				$("#mwt_mwt_slider_scroll").animate({ left:'0px' }, 600 ,'swing');
			}
			if ($("#mwt_mwt_slider_scroll").css('left') == '-'+(w+40)+'px')
			{
				wMode = "Bottom";
				$("#mwt_mwt_slider_scroll").animate({ left:'0px' }, 600 ,'swing');
			}
		}
	});


	$("#mwt_mwt_slider_scroll").mouseleave(function(){
		if (pinSlideTab) {
			if (wMode == "Top") {
				$("#mwt_mwt_slider_scroll").animate( { left:'-'+w+'px' }, 600 ,'swing');
			} else {
				$("#mwt_mwt_slider_scroll").animate( { left:'-'+(w+40)+'px' }, 600 ,'swing');
			}
		}
	});

	$("#messagePin").on("click", function() {
		if (pinSlideTab) {
			pinSlideTab = false;
			$("#messagePin").css("background-color", "#FFFFFF");
			$("#messagePin").css("color", "#009494");
		} else {
			pinSlideTab = true;
			$("#messagePin").css("background-color", "#009494");
			$("#messagePin").css("color", "#FFFFFF");
		}
	});
	postCanvas.canvas.parentNode.style.height = '232px';
	$.ajax({
		type: 'post',
		url: 'chart/chartSlidePostRaty.php',
		data: { slideCategory : '' },
		success: function (data) {
			var slideChartPost = JSON.parse(data);
			$("#slideRatyLeftSpanPost").text(slideChartPost[0]);
			var slidePostDoughnutData = {
				datasets: [{
					data: slideChartPost,
					backgroundColor: [
					'rgba(85, 173, 166, 0.8)',
					'rgba(136, 136, 137, 0.8)'
					]
				}]
			};
			var postCanvasChart = new Chart(postCanvas, {
				type: 'doughnut',
				data: slidePostDoughnutData,
				options: {
					title: {
						display: true
					},
					legend: {
						display : false
					},
					tooltips: {
						enabled : false
					},
					responsive:true,
					maintainAspectRatio: false
				}
			});
		}
	});

	var slideRaty1 = $("#slideBody").height();
	var slideRaty2 = $("#slidePostRatyChart").height();
	var slideRaty3 = $("#slidePostRatyCategory").height();
	$("#slidePostRatyList").css('height', ((slideRaty1 - slideRaty2 - slideRaty3 - 70) + "px"));
	$("#slideGetRatyList").css('height', ((slideRaty1 - slideRaty2 - slideRaty3 - 70) + "px"));

	getCanvas.canvas.parentNode.style.height = '232px';
	$.ajax({
		type: 'post',
		url: 'chart/chartSlideGetRaty.php',
		data: { slideCategory : '' },
		success: function (data) {
			var slideChartGet = JSON.parse(data);
			$("#slideRatyLeftSpanGet").text(slideChartGet[0]);
			var slideGetDoughnutData = {
				datasets: [{
					data: slideChartGet,
					backgroundColor: [
					'rgba(85, 173, 166, 0.8)',
					'rgba(136, 136, 137, 0.8)'
					]
				}]
			};
			var getCanvasChart = new Chart(getCanvas, {
				type: 'doughnut',
				data: slideGetDoughnutData,
				options: {
					title: {
						display: true
					},
					legend: {
						display : false
					},
					tooltips: {
						enabled : false
					},
					responsive:true,
					maintainAspectRatio: false
				}
			});
		}
	});

	$("#sendImgBtn").on('change', function() {
		var file = $('#sendImgBtn').get(0).files[0];
		var storageRef = firebase.storage().ref();
		var metadata = {
			contentType: 'image/jpeg'
		};

		var uploadTask = storageRef.child('images/' + file.name).put(file, metadata);

		uploadTask.on(firebase.storage.TaskEvent.STATE_CHANGED,
			function(snapshot) {
				var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
				console.log('Upload is ' + progress + '% done');
				switch (snapshot.state) {
					case firebase.storage.TaskState.PAUSED:
					console.log('Upload is paused');
					break;
					case firebase.storage.TaskState.RUNNING:
					console.log('Upload is running');
					break;
				}
			}, function(error) {
				switch (error.code) {
					case 'storage/unauthorized':
					break;

					case 'storage/canceled':
					break;

					case 'storage/unknown':
					break;
				}
			}, function() {
				uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
					sendImgToFirebase(downloadURL);
				});
			});
	});
});

function backToMessageList(caseID) {
	var checkDown = parseInt($.trim($("#messageNotifyCount").text()), 10);
	var checkDown1 = parseInt($.trim($("#messageNotifyChatCount" + caseID).text()), 10);
	$("#messageNotifyCount").text(checkDown - checkDown1);
	$("#messageNotifyChatCount" + caseID).text(0);
	$("#messageNotifyChat" + caseID).hide();
	if ((checkDown - checkDown1) <= 0) {
		$("#messageNotifyDiv").hide();
		$("#messageNotifyBtn").hide();
	}
	var messagesRef = firebase.database().ref('/messages/' + caseID);
	messagesRef.off('child_added');
	$("#slideMessageFirebase").hide();
	$("#slideMessageDiv").show();
}

function sendToFirebase(event, caseID) {
	if (event.which == 13) {
		var message = $("#sendMessageText").val();
		var messagesRef = firebase.database().ref('/messages/' + caseID);
		messagesRef.push({
			name: messageName,
			photoUrl: messageImg,
			text: message
		});
		$("#sendMessageText").val("");
		$.ajax({
			type: 'post',
			url: './ajax/ajaxSelectToken.php',
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
			},
			dataType:"json"
		});
	}
}

function sendImgToFirebase(downloadURL) {
	var caseID = $("#sendImgBtn").data("caseID");
	var message = $("#sendMessageText").val();
	var messagesRef = firebase.database().ref('/messages/' + caseID);
	messagesRef.push({
		name: messageName,
		photoUrl: messageImg,
		imageUrl: downloadURL
	});
	$("#sendMessageText").val("");
	$.ajax({
		type: 'post',
		url: './ajax/ajaxSelectToken.php',
		data: { caseID : caseID },
		success: function (data) {
			$.ajax({
				type: 'post',
				url: 'https://fcm.googleapis.com/fcm/send',
				beforeSend: function(request) {
					request.setRequestHeader("Authorization", "key=AAAAEFD1c04:APA91bGG5zG2wjf5M0BQtIHlB4VInlb-VhUtM9YkKcBEIz-xA5lgVk0ouQifciHUgchg-pMdLbYzc3b2IuSRlrhWPr7qIXieEXAqktNiOBYu7Y1SgcYES1EastyZrAEREJOdRtqdK2yF");
					request.setRequestHeader("Content-Type", "application/json");
				},
				data: JSON.stringify({"notification": {"title": messageName, "body": "傳送了一張圖片。"}, "data" : { "caseID" : caseID }, "to" : data[0]}),
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
				data: JSON.stringify({"notification": {"title": messageName, "body": "傳送了一張圖片。"}, "data" : { "caseID" : caseID }, "to" : data[1]}),
				error: function (jqXHR, exception) {
					console.log(jqXHR);
					console.log(exception);
				}
			});
		},
		dataType:"json"
	});
}

function showMessage(caseID, caseTitle, userName) {
	var checkDown = parseInt($.trim($("#messageNotifyCount").text()), 10);
	var checkDown1 = parseInt($.trim($("#messageNotifyChatCount" + caseID).text()), 10);
	$("#messageNotifyCount").text(checkDown - checkDown1);
	$("#messageNotifyChatCount" + caseID).text(0);
	$("#messageNotifyChat" + caseID).hide();
	if ((checkDown - checkDown1) <= 0) {
		$("#messageNotifyDiv").hide();
		$("#messageNotifyBtn").hide();
	}
	$("#slideMessageBody").empty();
	$("#slideMessageTitle").text(caseTitle);
	$("#backSlideMessage").attr("onclick","backToMessageList(" + caseID + ")");
	$("#sendMessageText").attr("onkeypress","sendToFirebase(event," + caseID + ")");
	$("#sendImgBtn").data("caseID", caseID);
	var h1 = $("#slideMessageHeader").height();
	var h2 = $("#slideBody").height();
	var h3 = $("#slideMessageFloot").height();
	$("#slideMessageBody").css('height', ((h2 - h1 - h3 - 95) + "px"));
	$("#slideMessageDiv").hide();
	$("#slideMessageFirebase").show();
	var messagesRef = firebase.database().ref('/messages/' + caseID);
	messagesRef.on('child_added', function(snapshot) {
		if (typeof(snapshot.val().imageUrl) == "undefined") {
			if (userName == snapshot.val().name) {
				$("#slideMessageBody").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><div class="myMessageText">' + snapshot.val().text + '</div></div>');
			} else {
				$("#slideMessageBody").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><div class="yourMessageText">' + snapshot.val().text + '</div></div>');
			}
		} else {
			if (userName == snapshot.val().name) {
				$("#slideMessageBody").append('<div class="text-right MessageDiv"><div class="myMessageName">' + snapshot.val().name + '</div><img onclick="showBigImg(event);" class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
			} else {
				$("#slideMessageBody").append('<div class="text-left MessageDiv"><div class="yourMessageName">' + snapshot.val().name + '</div><img onclick="showBigImg(event);" class="messageImg" src="' + snapshot.val().imageUrl + '" ></img></div>');
			}
		}

		var scrollHeight = $('#slideMessageBody').prop("scrollHeight");
		$('#slideMessageBody').animate({scrollTop:scrollHeight}, 10);
	});
}

function showSlideRatyPost(category) {
	$("#slidePostRatyList").empty();
	$.ajax({
		type: 'post',
		url: 'ajax/ajaxSlidePostRaty.php',
		data: { slideCategory : category },
		success: function (data) {
			$("#slidePostRatyList").prepend(data);
		}
	});
	$.ajax({
		type: 'post',
		url: 'chart/chartSlidePostRaty.php',
		data: { slideCategory : category },
		success: function (data) {
			var slideChartPost = JSON.parse(data);
			$("#slideRatyLeftSpanPost").text(slideChartPost[0]);
			var slidePostDoughnutData = {
				datasets: [{
					data: slideChartPost,
					backgroundColor: [
					'rgba(85, 173, 166, 0.8)',
					'rgba(136, 136, 137, 0.8)'
					]
				}]
			};
			var postCanvasChart = new Chart(postCanvas, {
				type: 'doughnut',
				data: slidePostDoughnutData,
				options: {
					title: {
						display: true
					},
					legend: {
						display : false
					},
					tooltips: {
						enabled : false
					},
					responsive:true,
					maintainAspectRatio: false
				}
			});
		}
	});
}

function showSlideRatyGet(category) {
	$("#slideGetRatyList").empty();
	$.ajax({
		type: 'post',
		url: 'ajax/ajaxSlideGetRaty.php',
		data: { slideCategory : category },
		success: function (data) {
			$("#slideGetRatyList").prepend(data);
		}
	});
	$.ajax({
		type: 'post',
		url: 'chart/chartSlideGetRaty.php',
		data: { slideCategory : category },
		success: function (data) {
			var slideChartGet = JSON.parse(data);
			$("#slideRatyLeftSpanGet").text(slideChartGet[0]);
			var slideGetDoughnutData = {
				datasets: [{
					data: slideChartGet,
					backgroundColor: [
					'rgba(85, 173, 166, 0.8)',
					'rgba(136, 136, 137, 0.8)'
					]
				}]
			};
			var getCanvasChart = new Chart(getCanvas, {
				type: 'doughnut',
				data: slideGetDoughnutData,
				options: {
					title: {
						display: true
					},
					legend: {
						display : false
					},
					tooltips: {
						enabled : false
					},
					responsive:true,
					maintainAspectRatio: false
				}
			});
		}
	});
}

function showBigImg(event) {
	var wH = screen.height;
	var wW = screen.width;
	var src = event.path[0].currentSrc;
	$("#bigImgModalDiv").empty();
	$("#bigImgModalDiv").prepend("<img class='bigImg' src='" + src + "'></img>");
	$("#bigImgModalDiv").css("max-height", wH * 0.9);
	$("#bigImgModalDiv").css("max-width", wW * 0.9);
	$("#bigImgModal").modal("show");
}