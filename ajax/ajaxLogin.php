<?php
session_start();
include("../mysqli_connect.inc.php");
if (@$_SESSION['userAccount'] != NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$userMail = $emailAddress . "@" . $emailServer;
$selectUser = "SELECT * FROM `users` WHERE `u_mail` = '$userMail' AND `u_pwd` = '$password'";
$queryUser = mysqli_query($link, $selectUser);
$resultUser = mysqli_fetch_array($queryUser);
if ($resultUser['u_uid'] == NULL) {
	echo "帳號或密碼錯誤，請確認後重新輸入。";
} else {
	$_SESSION['userID'] = $resultUser['u_uid'];
	$_SESSION['userAccount'] = $userMail;
	$_SESSION['userName'] = $resultUser['u_name'];
	$_SESSION['userNickName'] = $resultUser['u_nickname'];
	$_SESSION['userImg'] = "https://imgur.com/" . $resultUser['u_image'] . ".jpg";
	$_SESSION['verify'] = $resultUser['u_verify'];
	$_SESSION['level'] = $resultUser['u_level'];
	echo "login success";
}
?>