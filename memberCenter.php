<?php
session_start();
if (@$_SESSION['userID'] == null) {
	header("Location: error.php");
	exit;
}
$userID = $_SESSION['userID'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>會員中心 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="css/memberCenter.css" rel="stylesheet" type="text/css">
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
	$sexTrun = array("男性" => "男", "女性" => "女");
	$selectUser = "SELECT * FROM `users` WHERE `u_uid` = '$userID'";
	$queryUser = mysqli_query($link, $selectUser);
	$resultUser = mysqli_fetch_array($queryUser);
	$money = (string)$resultUser['u_money'];
	$money_len = strlen($money);
	if ($money_len > 3) {
		for ($i = $money_len-3;$i > 0;$i -= 3) {
			$money = substr($money, 0, $i) . "," . substr($money, $i);
		}
	}
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div" id="sta">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<h1 class="memberCenterSex"><?php echo $sexTrun[$resultUser['u_sex']]; ?></h1>
					<a href="#remmmm"><button class="button3">修改</button></a>
					<img src="img/anonymous2.png" class="img4">
					<img src="https://imgur.com/<?php echo $resultUser['u_image']; ?>.jpg" class="img1 img-circle headPhoto">
					<img src="img/anonymous.png" class="img2">
					<img src="img/editButton.png" class="img3">
				</div>
				<div class="col-sm-6">
					<table class="table">
						<thead>
							<tr>
								<th><h2>個人資料</h2></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="30%">姓名</td>
								<td><?php echo $resultUser['u_name']; ?></td>
							</tr>
							<tr>
								<td>暱稱</td>
								<td><?php echo $resultUser['u_nickname']; ?></td>
							</tr>
							<tr>
								<td>電話</td>
								<td><?php echo $resultUser['u_phone']; ?></td>
							</tr>

							<tr>
								<td>住址</td>
								<td><?php echo $resultUser['u_address']; ?></td>
							</tr>
							<tr>
								<td>帳號</td>
								<td><?php echo $resultUser['u_mail']; ?></td>
							</tr>
							<tr>
								<td>密碼</td>
								<td>(不顯示)</td>
							</tr>
							<tr>
								<td>存款</td>
								<td>NT$ <?php echo $money; ?></td>
							</tr>
							<tr>
								<td>身分證</td>
								<td><?php echo $resultUser['u_identity']; ?></td>
							</tr>
							<tr>
								<td>註冊時間</td>
								<td><?php echo $resultUser['u_regtime']; ?></td>
							</tr>
							<tr>
								<td>自我介紹</td>
								<td><?php echo $resultUser['u_introduce']; ?></td>
							</tr>
							<tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.php" ?>
		<script src="js/memberCenter.js"></script>