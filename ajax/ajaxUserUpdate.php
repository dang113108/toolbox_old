<?php
include("../mysqli_connect.inc.php");
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$email = $emailAddress . "@" . $emailServer;
$updatetUser = "UPDATE `users` SET `u_mail` = '$email', `u_pwd` = '$password', `u_identity` = '$userIdentity', `u_name` = '$userName', `u_nickname` = '$userNickname', `u_phone` = '$userCellphone', `u_address` = '$userAddress', `u_level` = '$userLevel', `u_black` = '$userEnable', `u_introduce` = '$userIntroduce' WHERE `u_uid` = '$userID'";
if (mysqli_query($link, $updatetUser)) {
	echo "update success";
} else {
	echo "更新失敗！請稍後再試";
}
?>