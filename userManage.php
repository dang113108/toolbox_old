<?php
session_start();
if (@$_SESSION['level'] != '管理員') {
	header("Location: error.php");
	exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>會員管理 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="css/caselist.css" rel="stylesheet" type="text/css">
	<link href="css/casesetting.css" rel="stylesheet" type="text/css">
	<link href="css/toast.css" rel="stylesheet" type="text/css">
	<link href="css/rwdTable.css" rel="stylesheet" type="text/css">
	<link href="css/kendo.common.min.css" rel="stylesheet" type="text/css">
	<link href="css/kendo.default.min.css" rel="stylesheet" type="text/css">
	<link href="css/kendo.default.mobile.min.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="js/userManage.js"></script>
	<script src="js/totop.js"></script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "navControl.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	foreach (@$_GET as $key => $value) {
		$$key = $value;
	}
	$selectUser = "SELECT COUNT(*) FROM `users`";
	$queryUser = mysqli_query($link, $selectUser);
	$resultCountUser = mysqli_num_rows($queryUser);
	$listPageCount = ceil($resultCountUser / 10);
	$selectUser = "SELECT * FROM `users`";
	$queryUser = mysqli_query($link, $selectUser);
	if (!isset($page)) {
		$page = 1;
	}
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div" id="sta">
		<table id="listTable" class="table-rwd">
			<tr class="t1 tr-only-hide">
				<th style="width: 3em;">UID</th>
				<th style="width: 12em;">帳號</th>
				<th style="width: 5em;">姓名</th>
				<th style="width: 7em;">暱稱</th>
				<th style="width: 4em;">驗證</th>
				<th style="width: 4em;">權限</th>
				<th style="width: 7em;">註冊</th>
			</tr>
			<?php
			foreach ($queryUser as $key => $value) {
				if ($key < ($page - 1) * 10) {
					continue;
				}
				?>
				<tr style="cursor: pointer;" data-toggle="modal" data-target="#userModal" data-whatever="<?php echo $value['u_uid']; ?>">
					<td data-th="UID"><?php echo $value['u_uid']; ?></td>
					<td data-th="帳號"><?php echo $value['u_mail']; ?></td>
					<td data-th="姓名"><?php echo $value['u_name']; ?></td>
					<td data-th="暱稱"><?php echo $value['u_nickname']; ?></td>
					<td data-th="驗證狀態"><?php echo $value['u_verify']; ?></td>
					<td data-th="權限"><?php echo $value['u_level']; ?></td>
					<td data-th="權限"><?php echo $value['u_regtime']; ?></td>
				</tr>
				<?php
				if ($key == (($page - 1) * 10 + 9)) {
					break;
				}
			} ?>
		</table>
		<br id="listBr">
		<nav id="listNav" aria-label="Page navigation example">
			<ul class="pagination justify-content-center">
				<?php for ($value = 1; $value <= $listPageCount; $value++) { ?>
					<li class="page-item listCase <?php if ($value == $page) { echo "active"; } ?>"><a class="page-link"><?php echo $value; ?></a></li>
				<?php } ?>
			</ul>
		</nav>
	</div>
	<?php include "footer.php" ?>

	<div id="userModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div id="modalDiv" class="modal-content">
			</div>
		</div>
	</div>

	<!-- 吐司 -->
	<div id="snackbar"></div>