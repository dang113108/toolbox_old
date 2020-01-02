<?php
session_start();
include("../mysqli_connect.inc.php");
if (@$_SESSION['verify'] != '未驗證') {
	header("Location: error.php");
	exit;
}
$userID = $_SESSION['userID'];
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$selectVerifyCode = "SELECT `u_verifyCode` FROM `users` WHERE `u_uid` = '$userID'";
$queryVerifyCode = mysqli_query($link, $selectVerifyCode);
$resultVerifyCode = mysqli_fetch_array($queryVerifyCode);
if ($resultVerifyCode['u_verifyCode'] == $verifyCode) {
	$updateCode = "UPDATE `users` SET `u_verify` = '已驗證' WHERE `u_uid` = '$userID'";
	if ($queryCode = mysqli_query($link, $updateCode)) {
		@$_SESSION['verify'] = '已驗證';
		echo "verify success";
		exit;
	}
}
echo "驗證錯誤，請檢查帳號以及驗證碼。";
?>