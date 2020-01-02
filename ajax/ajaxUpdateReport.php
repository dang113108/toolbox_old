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
$deleteCase = "UPDATE `report` SET `rp_status` = '處理中' WHERE `rp_cid` = '$caseID'";
mysqli_query($link, $deleteCase);
$updateCase = "UPDATE `cases` SET `c_status` = '爭議中' WHERE `c_cid` = '$caseID'";
mysqli_query($link, $updateCase);
$updateCase = "UPDATE `cases_copy` SET `c_status` = '爭議中' WHERE `c_cid` = '$caseID'";
mysqli_query($link, $updateCase);
?>