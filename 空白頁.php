<?php
session_start();
if (@$_SESSION['userID'] != null) {
	header("Location: error.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>輸入標題 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pagead2.googlesyndication.com/pagead/osd.js"></script>
	<script src="js/totop.js"></script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "nav.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div" id="sta">

	</div>
	<?php include "footer.php" ?>