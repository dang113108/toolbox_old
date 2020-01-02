<?php
session_start();
set_time_limit(0);
include("../mysqli_connect.inc.php");
if (@$_SESSION['userAccount'] == NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$selectDollar = "SELECT `u_money` FROM `users` WHERE `u_uid` = '$userID'";
$queryDollar = mysqli_query($link, $selectDollar);
$resultDollar = mysqli_fetch_array($queryDollar);
$lastDollar = $resultDollar['u_money'];
while ($lastDollar == $dollar) {
	sleep(5);
	$selectDollar = "SELECT `u_money` FROM `users` WHERE `u_uid` = '$userID'";
	$queryDollar = mysqli_query($link, $selectDollar);
	$resultDollar = mysqli_fetch_array($queryDollar);
	$lastDollar = $resultDollar['u_money'];
}
echo $lastDollar;
?>