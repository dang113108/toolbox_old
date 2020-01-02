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

  if ('serviceWorker' in navigator) {
  	console.log("test 'serviceWorker' in navigator");
  	navigator.serviceWorker.register('firebase-messaging-sw.js').then(function(registration) {
  		console.log('ServiceWorker registration successful with scope: ', registration.scope);
  		messaging.useServiceWorker(registration);
  		messaging.requestPermission()
  		.then(function() {
  			console.log('Notification permission granted.');
  			return messaging.getToken();
  		}).then(function(token) {
  			var xhr = new XMLHttpRequest();
  			xhr.open('POST', '/ajax/ajaxUpdateFirebaseToken.php', true);
  			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  			xhr.send('token=' + token);
  		}).catch(function(err) {
  			console.log('Unable to get permission to notify.', err);
  		});
  		messaging.onMessage(function(payload) {
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
        var notification = new Notification(notificationTitle,notificationOptions);
      });
  	}).catch(function(err) {
  		console.log('ServiceWorker registration failed: ', err);
  	});
  }

 // firebase.auth().signInWithEmailAndPassword("s10414102@gm.cyut.edu.tw", "a8735457").then(function() {
 // 	loginUser = firebase.auth().currentUser;
 // 	console.log(loginUser);
 // });