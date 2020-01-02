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
$selectCase = "SELECT `c_pid`, `c_rid` FROM `cases_copy` WHERE `c_cid` = '$caseID'";
$queryCase = mysqli_query($link, $selectCase);
$resultCase = mysqli_fetch_array($queryCase);
$rid = $resultCase['c_rid'];
$pid = $resultCase['c_pid'];
$echoArray = array();
$selectToken = "SELECT `u_Mtoken`, `u_Wtoken` FROM `users` WHERE `u_uid` = '$rid' OR `u_uid` = '$pid'";
$queryToken = mysqli_query($link, $selectToken);
while ($resultCase = mysqli_fetch_array($queryToken, MYSQLI_NUM)) {
	array_push($echoArray, $resultCase[0]);
	array_push($echoArray, $resultCase[1]);
}
array_push($echoArray, $caseID);
echo json_encode($echoArray);
?>