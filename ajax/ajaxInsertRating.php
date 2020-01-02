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
$selectRaty = "SELECT COUNT(*) FROM `rating` WHERE `rt_cid` = '$caseID'";
$queryRaty = mysqli_query($link, $selectRaty);
$countRaty = mysqli_fetch_array($queryRaty);
if ($postID == $userID) {
	$pid = $postID;
	$rid = $reciID;
} else {
	$pid = $reciID;
	$rid = $postID;
}
$insertRaty = "INSERT INTO `rating` (`rt_id`, `rt_cid`, `rt_category`, `rt_grade`, `rt_pid`, `rt_rid`, `rt_content`, `rt_time`) VALUES (NULL, '$caseID', '$category', '$ratyResult', '$pid', '$rid', '$ratyContent', CURRENT_TIMESTAMP)";
if (mysqli_query($link, $insertRaty)) {
	if ($countRaty[0] == '1') {
		$updateCase = "UPDATE `cases` SET `c_finish_time` = CURRENT_TIMESTAMP, `c_status` = '已完成' WHERE `c_cid` = '$caseID'";
		$updateCaseCopy = "UPDATE `cases_copy` SET `c_finish_time` = CURRENT_TIMESTAMP, `c_status` = '已完成' WHERE `c_cid` = '$caseID'";
		if (mysqli_query($link, $updateCase) && mysqli_query($link, $updateCaseCopy)) {
			echo "評價更新成功！"; //變成已完成
		} else {
			echo "評價失敗！請重新再試";
		}
	} else {
		echo "評價成功！";
	}
}
?>