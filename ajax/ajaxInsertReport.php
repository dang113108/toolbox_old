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
$reportContent = nl2br($reportContent);
$insertReport = "INSERT INTO `report` (`rp_rpid`, `rp_uid`, `rp_pid`, `rp_cid`, `rp_type`, `rp_content`, `rp_created`, `rp_updated`, `rp_status`) VALUES (NULL, '$userID', '$postID', '$caseID', '$reportItem', '$reportContent', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '未處理')";
if (mysqli_query($link, $insertReport)) {
	echo "Success";
} else {
	echo "Fail";
}
?>