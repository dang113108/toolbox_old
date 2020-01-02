<?php
session_start();
set_time_limit(0);
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
$oldNoticeID = 0;
$selectNotice = "SELECT * FROM `notice` WHERE `n_uid` = '$userID' ORDER BY `n_nid` DESC LIMIT 1";
$queryNotice = mysqli_query($link, $selectNotice);
$resultNotice = mysqli_fetch_array($queryNotice);
$lastNoticeID = $resultNotice['n_nid'];
while ($lastNoticeID <= $oldNoticeID) {
	usleep(1000000);
	clearstatcache();
	$selectNotice = "SELECT * FROM `notice` WHERE `n_uid` = '$userID' ORDER BY `n_nid` DESC LIMIT 1";
	$queryNotice = mysqli_query($link, $selectNotice);
	$resultNotice = mysqli_fetch_array($queryNotice);
	$lastNoticeID = $resultNotice['n_nid'];
}
$response = array();
$response['oldNoticeID'] = $lastNoticeID;
$response['n_category'] = $resultNotice['n_category'];
$response['n_message'] = $resultNotice['n_message'];
$response['n_url'] = $resultNotice['n_url'];
$response['n_created_at'] = $resultNotice['n_created_at'];
echo json_encode($response);
?>