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
$selectCase = "SELECT `c_pid`, `c_rid` FROM `cases` WHERE `c_cid` = '$caseID'";
$queryCase = mysqli_query($link, $selectCase);
$resultCase = mysqli_fetch_array($queryCase);
$selectToken = "SELECT `u_Mtoken`, `u_Wtoken` FROM `users` WHERE `u_uid` = '$userID'";
$queryToken = mysqli_query($link, $selectToken);
$resultCase = mysqli_fetch_array($queryToken, MYSQLI_NUM);
array_push($resultCase, $caseID);
echo json_encode($resultCase);
?>