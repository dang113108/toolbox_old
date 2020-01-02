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
if ($c_status == "已完成") {
	$updateCase = "UPDATE `cases` SET `c_finish_time` = CURRENT_TIMESTAMP, `c_status` = '$c_status' WHERE `c_cid` = '$caseID'";
	$updateCaseCopy = "UPDATE `cases_copy` SET `c_finish_time` = CURRENT_TIMESTAMP, `c_status` = '$c_status' WHERE `c_cid` = '$caseID'";
} else {
	$updateCase = "UPDATE `cases` SET  `c_status` = '$c_status' WHERE `c_cid` = '$caseID'";
	$updateCaseCopy = "UPDATE `cases_copy` SET  `c_status` = '$c_status' WHERE `c_cid` = '$caseID'";
}
if (mysqli_query($link, $updateCase) && mysqli_query($link, $updateCaseCopy)) {
	echo "更新成功";
} else {
	echo "更新失敗！請重新再試";
}
?>