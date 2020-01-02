<?php
session_start();
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
$selectMessage = "SELECT * FROM `message` WHERE `m_mid` = '$m_mid'";
$queryMessage = mysqli_query($link, $selectMessage);
$resultMessage = mysqli_fetch_array($queryMessage);
$caseID = $resultMessage['c_cid'];
$rID = $resultMessage['u_uid'];
$updateCase = "UPDATE `cases` SET `c_rid` = '$rID', `c_status` = '進行中' WHERE `c_cid` = '$caseID'";
$updateCaseCopy = "UPDATE `cases_copy` SET `c_rid` = '$rID', `c_status` = '進行中' WHERE `c_cid` = '$caseID'";
$deleteMessage = "DELETE FROM `message` WHERE `c_cid` = '$caseID'";
if (mysqli_query($link, $updateCase) && mysqli_query($link, $updateCaseCopy) && mysqli_query($link, $deleteMessage)) {
	$selectCase = "SELECT * FROM `cases` WHERE `c_cid` = $caseID";
	$queryCase = mysqli_query($link, $selectCase);
	$resultCase = mysqli_fetch_array($queryCase, MYSQLI_ASSOC);
	echo json_encode($resultCase);
} else {
	echo "選擇失敗！請重新再試";
}
?>