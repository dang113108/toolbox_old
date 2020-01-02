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
	<title>趨勢分析 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="css/chart.css" rel="stylesheet" type="text/css">
	<script defer src="https://use.fontawesome.com/releases/v5.4.2/js/all.js" integrity="sha384-wp96dIgDl5BLlOXb4VMinXPNiB32VYBSoXOoiARzSTXY+tsK8yDTYfvdTyqzdGGN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pagead2.googlesyndication.com/pagead/osd.js"></script>
	<script src="js/totop.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js" integrity="sha256-MZo5XY1Ah7Z2Aui4/alkfeiq3CopMdV/bbkc/Sh41+s=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" integrity="sha256-oSgtFCCmHWRPQ/JmR4OoZ3Xke1Pw4v50uh6pLcu+fIc=" crossorigin="anonymous"></script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "navControl.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div" id="sta">
		<div id="carouselExampleIndicators" class="carousel slide" data-pause=true data-ride=false>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="divBg50">
						<canvas id="category7Doughnut"></canvas>
					</div>
					<div class="divBg50">
						<canvas id="status7Doughnut"></canvas>
					</div>
				</div>
				<div class="carousel-item">
					<div class="divBg50">
						<canvas id="categoryDoughnut"></canvas>
					</div>
					<div class="divBg50">
						<canvas id="statusDoughnut"></canvas>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev nextBtnDiv" href="#carouselExampleIndicators" role="button" data-slide="prev">
				<i class="fas fa-chevron-left nextBtn"></i>
			</a>
			<a class="carousel-control-next nextBtnDiv" href="#carouselExampleIndicators" role="button" data-slide="next">
				<i class="fas fa-chevron-right nextBtn"></i>
			</a>
		</div>
		<div id="carouselExampleIndicators1" class="carousel slide" data-pause=true data-ride=false>
			<div class="carousel-inner">
				<div class="carousel-item active">
					<div class="divBg100">
						<canvas id="categoryLine"></canvas>
					</div>
				</div>
				<div class="carousel-item">
					<div class="divBg100">
						<canvas id="categoryLine1"></canvas>
					</div>
				</div>
				<div class="carousel-item">
					<div class="divBg100">
						<canvas id="categoryLine2"></canvas>
					</div>
				</div>
			</div>
			<a class="carousel-control-prev nextBtnDiv" href="#carouselExampleIndicators1" role="button" data-slide="prev">
				<i class="fas fa-chevron-left nextBtn" aria-hidden="true"></i>
			</a>
			<a class="carousel-control-next nextBtnDiv" href="#carouselExampleIndicators1" role="button" data-slide="next">
				<i class="fas fa-chevron-right nextBtn" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<div></div>
	<script src="js/chart.js" type="text/javascript"></script>