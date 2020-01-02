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
if ($status == "收藏") {
	$insertCollect = "INSERT INTO `collection` (`cn_cid`, `c_cid`, `u_uid`) VALUES (NULL, '$caseID', '$userID')";
	if (mysqli_query($link, $insertCollect)) {
		echo "取消";
	}
} else {
	$insertCollect = "DELETE FROM `collection` WHERE `c_cid` = '$caseID' AND `u_uid` = '$userID'";
	if (mysqli_query($link, $insertCollect)) {
		echo "收藏";
	}
}
?>