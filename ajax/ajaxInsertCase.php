<?php
session_start();
include("../mysqli_connect.inc.php");
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
if (@$_SESSION['userAccount'] == NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$c_detail = nl2br($c_detail);
$selectUser = "SELECT * FROM `users` WHERE `u_uid` = '$userID'";
$queryUser = mysqli_query($link, $selectUser);
$resultUser = mysqli_fetch_array($queryUser);
if ($resultUser['u_money'] < $c_money) {
	echo "餘額不足，請先進行LINE PAY儲值。";
	exit;
}

date_default_timezone_set('Asia/Taipei');
$Y = @date(Y);
$m = @date(m);
$d = @date(d);
$H = @date(H);
$i = @date(i);
$s = @date(s);
$c_until = date("Y-m-d H:i:s", mktime($H + $c_hour, $i + $c_mins, $s, $m, $d, $Y));
if ($c_finish_end == "設定時間") {
	$c_finish_end = $settime;
} else {
	$c_finish_end = "0000-00-00 00:00:00";
}
$insertCase = "INSERT INTO `cases` (`c_cid`, `c_pid`, `c_rid`, `c_city`, `c_town`, `c_road`, `c_address`, `c_category`, `c_title`, `c_money`, `c_message`, `c_time`, `c_until`, `c_finish_end`, `c_finish_time`, `c_detail`, `c_status`) VALUES (NULL, '$userID', '$userID', '$c_city', '$c_town', '$c_road', '$c_address', '$c_category', '$c_title', '$c_money', '', CURRENT_TIMESTAMP, '$c_until', '$c_finish_end', NULL, '$c_detail', '待接案')";
$insertCaseCopy = "INSERT INTO `cases_copy` (`c_cid`, `c_pid`, `c_rid`, `c_city`, `c_town`, `c_road`, `c_address`, `c_category`, `c_title`, `c_money`, `c_message`, `c_time`, `c_until`, `c_finish_end`, `c_finish_time`, `c_detail`, `c_status`) VALUES (NULL, '$userID', '$userID', '$c_city', '$c_town', '$c_road', '$c_address', '$c_category', '$c_title', '$c_money', '', CURRENT_TIMESTAMP, '$c_until', '$c_finish_end', NULL, '$c_detail', '待接案')";
$updateUser = "UPDATE `users` SET `u_money` = u_money - $c_money WHERE `u_uid` = '$userID'";
if (!mysqli_query($link, $insertCase)) {
	echo "案件寫入失敗，請重新確認。1" . mysqli_error($link);
	exit;
}
if (!mysqli_query($link, $insertCaseCopy)) {
	echo "案件寫入失敗，請重新確認。2" . mysqli_error($link);
	exit;
}
if (!mysqli_query($link, $updateUser)) {
	echo "案件寫入失敗，請重新確認。3" . mysqli_error($link);
	exit;
}
echo "insert success";
?>