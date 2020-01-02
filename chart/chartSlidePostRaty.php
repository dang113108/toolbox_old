<?php
session_start();
include("../mysqli_connect.inc.php");
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
foreach (@$_POST as $key => $value) {
	$$key = $value;
}
$countAll = 0;
$countRaty = 0;
if (@$slideCategory == "") {
	$selectRaty = "SELECT * FROM `rating` WHERE `rt_rid` = '$userID'";
} else {
	$selectRaty = "SELECT * FROM `rating` WHERE `rt_rid` = '$userID' AND `rt_category` = '$slideCategory'";
}
$queryRaty = mysqli_query($link, $selectRaty);
while (@$resultRaty = mysqli_fetch_array($queryRaty)) {
	$caseID = $resultRaty['rt_cid'];
	$selectPost = "SELECT *, `u_nickname` FROM `cases_copy`, `users` WHERE `cases_copy`.`c_cid` = '$caseID' AND `cases_copy`.`c_pid` = '$userID' AND `cases_copy`.`c_rid` = `users`.`u_uid`";
	$queryPost = mysqli_query($link, $selectPost);
	$resultPost = mysqli_fetch_array($queryPost);
	if ($resultPost['c_cid'] != "") {
		$countAll++;
		$countRaty += $resultRaty['rt_grade'];
	}
}
if ($countAll != 0) {
	echo json_encode(array(round($countRaty / $countAll, 1), 5 - round($countRaty / $countAll, 1)));
} else {
	echo json_encode(array(0, 5));
}
?>