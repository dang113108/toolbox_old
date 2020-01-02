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
$selectMsg = "SELECT `u_uid` FROM `message` WHERE `c_cid` = '$caseID' AND `u_uid` != '$taskerID'";
$queryMsg = mysqli_query($link, $selectMsg);
$resultMsg = mysqli_fetch_array($queryMsg, MYSQLI_NUM);
echo @implode(',', @$resultMsg);
?>