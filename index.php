<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>首頁 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link href="css/index.css" rel="stylesheet" type="text/css">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<script defer src="https://use.fontawesome.com/releases/v5.4.2/js/all.js" integrity="sha384-wp96dIgDl5BLlOXb4VMinXPNiB32VYBSoXOoiARzSTXY+tsK8yDTYfvdTyqzdGGN" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="js/countUp.js" type="text/javascript"></script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "indexNav.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	$selectCase = "SELECT * FROM `cases_copy`";
	$queryCase = mysqli_query($link, $selectCase);
	$countAll = 0;
	$countFinish = 0;
	$countGet = 0;
	$count0 = 0;
	$count1 = 0;
	$count2 = 0;
	$count3 = 0;
	$count4 = 0;
	$count5 = 0;
	$countMoney0 = 0;
	$countMoney1 = 0;
	$countMoney2 = 0;
	$countMoney3 = 0;
	$countMoney4 = 0;
	$countMoney5 = 0;
	$countMoney00 = 0;
	$countMoney11 = 0;
	$countMoney22 = 0;
	$countMoney33 = 0;
	$countMoney44 = 0;
	$countMoney55 = 0;
	while ($resultCase = mysqli_fetch_array($queryCase)) {
		$countAll++;
		if ($resultCase['c_status'] == '已完成') {
			switch ($resultCase['c_category']) {
				case '日常':
				$count0++;
				break;
				case '接送':
				$count1++;
				break;
				case '外送':
				$count2++;
				break;
				case '課業':
				$count3++;
				break;
				case '修繕':
				$count4++;
				break;
				case '除蟲':
				$count5++;
				break;
			}
			$countFinish++;
		}
		if ($resultCase['c_status'] != '待接案') {
			$countGet++;
		}
		switch ($resultCase['c_category']) {
			case '日常':
			$countMoney0 += $resultCase['c_money'];
			$countMoney00++;
			break;
			case '接送':
			$countMoney1 += $resultCase['c_money'];
			$countMoney11++;
			break;
			case '外送':
			$countMoney2 += $resultCase['c_money'];
			$countMoney22++;
			break;
			case '課業':
			$countMoney3 += $resultCase['c_money'];
			$countMoney33++;
			break;
			case '修繕':
			$countMoney4 += $resultCase['c_money'];
			$countMoney44++;
			break;
			case '除蟲':
			$countMoney5 += $resultCase['c_money'];
			$countMoney55++;
			break;
		}
	}
	//------------------------BODY區
	?>

	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
			<li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
		</ol>
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-100" src="img/index/00.png" alt="First slide">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="img/index/01.png" alt="Second slide">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="img/index/02.png" alt="Third slide">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="img/index/03.png" alt="Third slide">
			</div>
		</div>
		<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>

	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-2">
				<span class="fas fa-lightbulb logo slide indexLogo"></span>
			</div>
			<div class="col-sm-4 d1 slide">
				<span class="d2">起源</span>
				<p>我們的發想來自於學生發起的「載你一程」活動，有車的同學可以順道載有需求的同學到學校去上課，但是宣傳效果不彰。</p>
				<p>因此我們設計這個APP，需求者可以透過「工具箱」發出自己的需求，讓有意願者可以接案並幫助需求者解決需求。</p>
			</div>
			<div class="col-sm-3"></div>
		</div>
	</div>
	<div class="container-fluid text-center bg-g slideanim">
		<span class="d3">案件完成數</span><br>
		<span class="d2 slowNumber"><?php echo $countFinish; ?></span><span class="d2">件</span>
		<br><br>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-1">
				<img src="img/index/icon/01.png"><br>
				<span class="d4">日常</span><br>
				<span class="d5 slowNumber"><?php echo $count0; ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/02.png"><br>
				<span class="d4">接送</span><br>
				<span class="d5 slowNumber"><?php echo $count1; ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/03.png"><br>
				<span class="d4">外送</span><br>
				<span class="d5 slowNumber"><?php echo $count2; ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/04.png"><br>
				<span class="d4">課業</span><br>
				<span class="d5 slowNumber"><?php echo $count3; ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/05.png"><br>
				<span class="d4">修繕</span><br>
				<span class="d5 slowNumber"><?php echo $count4; ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/06.png"><br>
				<span class="d4">除蟲</span><br>
				<span class="d5 slowNumber"><?php echo $count5; ?></span>
			</div>
			<div class="col-sm-3"></div>

		</div>
	</div>

	<div class="container-fluid text-center slideanim1">
		<span class="d3">各分類平均交易金額 / NT</span><br>
		<br><br>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-1">
				<img src="img/index/icon/01.png"><br>
				<span class="d4">日常</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney0 / $countMoney00); ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/02.png"><br>
				<span class="d4">接送</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney1 / $countMoney11); ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/03.png"><br>
				<span class="d4">外送</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney2 / $countMoney22); ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/04.png"><br>
				<span class="d4">課業</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney3 / $countMoney33); ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/05.png"><br>
				<span class="d4">修繕</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney4 / $countMoney44); ?></span>
			</div>
			<div class="col-sm-1">
				<img src="img/index/icon/06.png"><br>
				<span class="d4">除蟲</span><br>
				<span class="d5">$ </span><span class="d5 slowNumber1"><?php echo round($countMoney5 / $countMoney55); ?></span>
			</div>
			<div class="col-sm-3"></div>

		</div>
	</div>

	<div class="container-fluid text-center bg-g slideanim2">
		<br><br>
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-2 ">
				<span class="d6">案件平均完成時間</span><br><br>
				<i class="far fa-clock fa-6x con indexLogo"></i><br><br>
				<span class="d5 slowNumber2">100</span><span class="d5"> / min</span>
			</div>

			<div class="col-sm-2">
				<span class="d6">發案數量</span><br><br>

				<i class="fas fa-scroll fa-6x con indexLogo"></i><br><br>
				<span class="d5 slowNumber2"><?php echo $countAll; ?></span>
			</div>
			<div class="col-sm-2">
				<span class="d6">接案數量</span><br><br>

				<i class="fas fa-feather-alt fa-6x con indexLogo"></i><br><br>
				<span class="d5 slowNumber2"><?php echo $countGet; ?></span>
			</div>
			<div class="col-sm-3"></div>

		</div>
	</div>
	<?php include "footer.php" ?>