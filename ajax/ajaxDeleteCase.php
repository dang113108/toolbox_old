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
$deleteCase = "DELETE FROM `cases` WHERE `c_cid` = '$caseID'";
mysqli_query($link, $deleteCase);
$deleteCase = "DELETE FROM `cases_copy` WHERE `c_cid` = '$caseID'";
mysqli_query($link, $deleteCase);
?>