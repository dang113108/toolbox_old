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
	<title>註冊 - ToolBox</title>
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
	<script src="js/register.js"></script>
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
		<form name="registerForm" id="registerForm" enctype="multipart/form-data" method="POST" oninput="passwordCheck.setCustomValidity(password.value != passwordCheck.value ? '兩次密碼輸入不同，請重新輸入。' : '')">
			<div class="form-row">
				<div class="col">
					<div class="form-group text-center">
						<img class="img-circle img-thumbnail img-responsive imgCSS" id="thumbnil" src="img/anonymous.png" alt=""/>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<div class="form-group text-center">
						<label class="audio btn btn-info themeBGColor">
							<input type="file" style="display:none;" accept="image/*" id="userImage" name="userImage" onchange="showMyImage(this)" required>
							<div id="fileTitle" name="fileTitle">點我上傳大頭貼</div>
						</label>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="emailAddress">Email 帳號</label>
					<input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="輸入您的學號" pattern="[A-Za-z0-9]+" minlength="2" maxlength="40" required>
				</div>
				<div class="form-group col-md-6">
					<label for="emailServer">Email 伺服器</label>
					<select id="emailServer" name="emailServer" class="form-control">
						<option value="gm.cyut.edu.tw">@gm.cyut.edu.tw</option>
						<option value="cyut.edu.tw">@cyut.edu.tw</option>
					</select>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="password">密碼</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="輸入您的密碼" minlength="6" maxlength="12" required>
				</div>
				<div class="form-group col-md-6">
					<label for="passwordCheck">確認密碼</label>
					<input type="password" class="form-control" id="passwordCheck" name="passwordCheck" placeholder="再輸入一次您的密碼" minlength="6" maxlength="12" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="userName">姓名</label>
					<input type="text" class="form-control" id="userName" name="userName" placeholder="輸入您的姓名" minlength="2" maxlength="10" required>
				</div>
				<div class="form-group col-md-6">
					<label for="userNickname">暱稱</label>
					<input type="text" class="form-control" id="userNickname" name="userNickname" placeholder="輸入您的暱稱" minlength="2" maxlength="10" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="userIdentity">身分證字號</label>
					<input type="text" class="form-control" id="userIdentity" name="userIdentity" placeholder="輸入您的身分證字號" pattern="[A-Za-z0-9]+" minlength="10" maxlength="10" onblur="pidtest()" required>
				</div>
				<div class="form-group col-md-6">
					<label for="userSex">性別</label>
					<input type="text" class="form-control" id="userSex" name="userSex" value="" readonly required>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<div class="form-group">
						<label for="userCellphone">手機</label>
						<input type="text" class="form-control" id="userCellphone" name="userCellphone" placeholder="輸入您的手機號碼" pattern="[0-9]+" minlength="10" maxlength="10" required>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<div class="form-group">
						<label for="userAddress">住址</label>
						<input type="text" class="form-control" id="userAddress" name="userAddress" placeholder="輸入您的現居地址" minlength="2" maxlength="50" required>
					</div>
				</div>
			</div>
			<div class="form-row">
				<div class="col">
					<div class="form-group">
						<label for="userIntroduce">自我介紹</label>
						<textarea class="form-control" id="userIntroduce" name="userIntroduce" rows="3" minlength="10" maxlength="500" required></textarea>
					</div>
				</div>
			</div>
			<div class="form_row">
				<button type="submit" class="btn btn-primary form-control themeBGColor">註冊</button>
			</div>
		</form>
	</div>

	<!-- 吐司 -->
	<div id="snackbar"></div>

	<?php include "footer.php" ?>