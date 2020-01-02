<?php
session_start();
include("../mysqli_connect.inc.php");
if (@$_SESSION['userAccount'] == NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
date_default_timezone_set('Asia/Taipei');
$Y = @date(Y);
$m = @date(m);
$d = @date(d);
$H = @date(H);
$i = @date(i);
$s = @date(s);
$c_until = date("Y-m-d H:i:s", mktime($H + $c_hour, $i + $c_mins, $s, $m, $d, $Y));
$message = nl2br($message);
$selectTime = "SELECT CURRENT_TIMESTAMP";
$queryTime = mysqli_query($link, $selectTime);
$resultTime = mysqli_fetch_array($queryTime);
$insertMessage = "INSERT INTO `message` (`m_mid`, `c_cid`, `u_uid`, `m_message`, `m_time`, `m_created_at`) VALUES (NULL, '$caseID', '$userID', '$message', '$c_until', CURRENT_TIMESTAMP)";
if (mysqli_query($link, $insertMessage)) {
	echo "Insert Success!";
} ?>