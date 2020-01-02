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
	<title>登入 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="css/toast.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pagead2.googlesyndication.com/pagead/osd.js"></script>
	<script src="js/totop.js"></script>
	<script src="js/login.js"></script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "nav.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div" id="sta">
		<form id="loginForm" class="loginMargin" name="form" id="form" method="POST">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="emailAddress">Email 帳號</label>
					<input type="text" class="form-control" name="emailAddress" id="emailAddress" placeholder="輸入您的電子信箱帳號" pattern="[A-Za-z0-9]+" minlength="2" maxlength="40" required>
				</div>
				<div class="form-group col-md-6">
					<label for="emailServer">Email 伺服器</label>
					<select name="emailServer" class="form-control">
						<option value="gm.cyut.edu.tw">@gm.cyut.edu.tw</option>
						<option value="cyut.edu.tw">@cyut.edu.tw</option>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<div class="form-group">
						<label for="password">密碼</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="輸入您的密碼" minlength="6" maxlength="12" required>
					</div>
				</div>
			</div>
			<div class="form_row">
				<div class="col">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="exampleCheck1">
						<label class="form-check-label" for="exampleCheck1">記住我</label>
					</div>
				</div>
			</div>
			<div class="form_row">
				<button type="submit" class="btn btn-primary form-control themeBGColor">登入</button>
			</div>
		</form>

		<!-- 吐司 -->
		<div id="snackbar"></div>

	</div>
	<?php include "footer.php" ?>