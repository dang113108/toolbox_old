<?php
session_start();
include("../mysqli_connect.inc.php");
if (@$_SESSION['userAccount'] != NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
?>