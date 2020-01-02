// Import and configure the Firebase SDK
// These scripts are made available when the app is served or deployed on Firebase Hosting
// If you do not serve/host your project using Firebase Hosting see https://firebase.google.com/docs/web/setup
importScripts('https://www.gstatic.com/firebasejs/4.5.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.5.2/firebase-messaging.js');
importScripts('https://www.gstatic.com/firebasejs/4.5.2/firebase.js');

  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyD96VL5J-PG9xP3xU64qZN260RGTBKuAwU",
    authDomain: "toolbox-796e8.firebaseapp.com",
    databaseURL: "https://toolbox-796e8.firebaseio.com",
    projectId: "toolbox-796e8",
    storageBucket: "toolbox-796e8.appspot.com",
    messagingSenderId: "70077739854"
  };
  firebase.initializeApp(config);

  const messaging = firebase.messaging();

// If you would like to customize notifications that are received in the
// background (Web app is closed or not in browser focus) then you should
// implement this optional method.
// [START background_handler]

messaging.setBackgroundMessageHandler(function(payload) {
  if ($("#messageNotifyChat" + payload.data.caseID).length <= 0) {
    $.ajax({
      type: 'post',
      url: 'ajax/ajaxAddSlideMessage.php',
      data: {
        caseID : payload.data.caseID
      },
      success: function (data) {
        $("#slideMessageDiv").prepend(data);
      }
    });
    $.ajax({
      type: 'post',
      url: 'ajax/ajaxAddSlideGet.php',
      data: {
        caseID : payload.data.caseID
      },
      success: function (data) {
        $("#pills-profile").prepend(data);
      }
    });
    $("#listStatusImg" + payload.data.caseID).attr("src", "../img/keeping.png");
    $("#gridStatusDiv" + payload.data.caseID).text("進行中");
    $("#gridStatusDiv" + payload.data.caseID).toggleClass('waiting keeping');
  }
  var checkDown = parseInt($.trim($("#messageNotifyCount").text()), 10);
  $("#messageNotifyCount").text(checkDown + 1);
  $("#messageNotifyDiv").css("display", "block");
  $("#messageNotifyBtn").css("display", "inline-block");
  $("#messageNotifyChat" + payload.data.caseID).css("display", "inline-block");
  var checkDown = parseInt($.trim($("#messageNotifyChatCount" + payload.data.caseID).text()), 10);
  $("#messageNotifyChatCount" + payload.data.caseID).text(checkDown + 1);
  const notificationTitle = payload.notification.title;
  const notificationOptions = {
    body: payload.notification.body,
    icon: '/img/LOGO.png'
  };
  return self.registration.showNotification(notificationTitle,
    notificationOptions);
});
// [END background_handler]