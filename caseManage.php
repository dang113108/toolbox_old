<?php
session_start();
if (@$_SESSION['level'] != '管理員') {
	header("Location: error.php");
	exit;
}
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>案件管理 - ToolBox</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link href="css/normal.css" rel="stylesheet" type="text/css">
	<link href="css/caselist.css" rel="stylesheet" type="text/css">
	<link href="css/slideTab.css" rel="stylesheet" type="text/css">
	<link href="css/caseManage.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://pagead2.googlesyndication.com/pagead/osd.js"></script>
	<script src="js/totop.js"></script>
	<script src="js/caseManage.js"></script>
	<script>
		var messageName = '<?php echo @$userName; ?>';
		var messageImg = '<?php echo @$userImg; ?>';
	</script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "navControl.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	//------------------------變數區
	$img_url = "img/";
	$category_img_url = "icon-color/";
	$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
	$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
	$selectCase = "SELECT * FROM `cases_copy` ORDER BY `c_cid` DESC";
	$queryCase = mysqli_query($link, $selectCase);
	$selectReport = "SELECT * FROM `report` WHERE `rp_status` != '未處理'";
	$queryReport = mysqli_query($link, $selectReport);
	$selectReport1 = "SELECT * FROM `report` WHERE `rp_status` = '未處理'";
	$queryReport1 = mysqli_query($link, $selectReport1);
	//------------------------BODY區
	?>

	<div align="center text-left" class="container-fluid body_div container cancelPadding" id="sta">
		<nav>
			<div class="nav nav-tabs justify-content-end" id="nav-tab" role="tablist">
				<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">所有案件</a>
				<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">已受理檢舉</a>
				<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">未受理檢舉</a>
			</div>
		</nav>
		<div id="outerDiv">
			<div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<div class="row">
						<div id="leftDiv" class="col leftDiv">
							<?php while ($resultCase = mysqli_fetch_array($queryCase)) { ?>
								<div id="slideCardBody<?php echo $resultCase['c_cid']; ?>" class="card slideCardBody" style="cursor: pointer;" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $resultCase['c_cid']; ?>" onclick="showMessage(<?php echo $resultCase['c_cid'] . ",'" . $resultCase['c_title'] . "'" . ",'" . $userName . "'"; ?>);">
									<div class="row text-left">
										<div class="col-5"><img src="<?php echo $img_url . $status_array[$resultCase['c_status']]; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$resultCase['c_category']]; ?>"></div>
										<div class="col-7 messageTitle"><?php echo $resultCase['c_title']; ?></div>
										<div class="w-100"></div>
										<div class="col-5">NT$ <?php echo $resultCase['c_money']; ?></div>
										<div class="col-7 messageTitle"><?php echo $resultCase['c_city'] . $resultCase['c_town'] . $resultCase['c_road']; ?></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-8">
							<div class="rightDiv">
								<div class="rightDivHeader">
									<div class="sameline" id="rightDivHeader"></div>
									<div class="sameLineRight">
										<i id="caseInfoIcon" class="fas fa-info-circle iconHover" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $resultCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="查看案件內容"></i>
										<i id="caseDelIcon" class="fas fa-trash iconHover" data-whatever="<?php echo $resultCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="刪除該案件"></i>
									</div>
									<div class="noFloat"></div>
								</div>
								<div id="rightDivBody" class="rightDivBody">
									請選擇一個案件以便觀看。
								</div>
								<div id="rightDivFooter" class="rightDivFooter">
									<textarea id="messageArea" class="sendArea" autocomplete="off" name="messageArea" placeholder="輸入訊息…"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<div class="row">
						<div id="leftDiv1" class="col leftDiv">
							<?php while (@$resultReport = mysqli_fetch_array($queryReport)) {
								$caseID = $resultReport['rp_cid'];
								$selectCase = "SELECT * FROM `cases_copy` WHERE `c_cid` = '$caseID'";
								$queryCase = mysqli_query($link, $selectCase);
								$reslutCase = mysqli_fetch_array($queryCase);
								?>
								<div id="slideCardBody1<?php echo $reslutCase['c_cid']; ?>" class="card slideCardBody" style="cursor: pointer;" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $reslutCase['c_cid']; ?>" onclick="showMessage1(<?php echo $reslutCase['c_cid'] . ",'" . $reslutCase['c_title'] . "'" . ",'" . $userName . "'"; ?>);">
									<div class="row text-left">
										<div class="col-5"><img src="<?php echo $img_url . $status_array[$reslutCase['c_status']]; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$reslutCase['c_category']]; ?>"></div>
										<div class="col-7 messageTitle"><?php echo $reslutCase['c_title']; ?></div>
										<div class="w-100"></div>
										<div class="col-5">NT$ <?php echo $reslutCase['c_money']; ?></div>
										<div class="col-7 messageTitle"><?php echo $reslutCase['c_city'] . $reslutCase['c_town'] . $reslutCase['c_road']; ?></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-8">
							<div class="rightDiv">
								<div class="rightDivHeader">
									<div class="sameline" id="rightDivHeader1"></div>
									<div class="sameLineRight">
										<i id="caseInfoIcon1" class="fas fa-info-circle iconHover" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="查看案件內容"></i>
										<i id="caseDelIcon1" class="fas fa-trash iconHover" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="刪除該案件"></i>
									</div>
									<div class="noFloat"></div>
								</div>
								<div id="rightDivBody1" class="rightDivBody">
									請選擇一個案件以便觀看。
								</div>
								<div id="rightDivFooter1" class="rightDivFooter">
									<textarea id="messageArea1" class="sendArea" autocomplete="off" name="messageArea" placeholder="輸入訊息…"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					<div class="row">
						<div id="leftDiv2" class="col leftDiv">
							<?php while (@$resultReport = mysqli_fetch_array($queryReport1)) {
								$caseID = $resultReport['rp_cid'];
								$selectCase = "SELECT * FROM `cases_copy` WHERE `c_cid` = '$caseID'";
								$queryCase = mysqli_query($link, $selectCase);
								$reslutCase = mysqli_fetch_array($queryCase);
								?>
								<div id="slideCardBody2<?php echo $reslutCase['c_cid']; ?>" class="card slideCardBody" style="cursor: pointer;" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $reslutCase['c_cid']; ?>" onclick="showMessage2(<?php echo $reslutCase['c_cid'] . ",'" . $reslutCase['c_title'] . "'" . ",'" . $userName . "'"; ?>);">
									<div class="row text-left">
										<div class="col-5"><img src="<?php echo $img_url . $status_array[$reslutCase['c_status']]; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$reslutCase['c_category']]; ?>"></div>
										<div class="col-7 messageTitle"><?php echo $reslutCase['c_title']; ?></div>
										<div class="w-100"></div>
										<div class="col-5">NT$ <?php echo $reslutCase['c_money']; ?></div>
										<div class="col-7 messageTitle"><?php echo $reslutCase['c_city'] . $reslutCase['c_town'] . $reslutCase['c_road']; ?></div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="col-8">
							<div class="rightDiv">
								<div class="rightDivHeader">
									<div class="sameline" id="rightDivHeader2"></div>
									<div class="sameLineRight">
										<i id="caseInfoIcon2" class="fas fa-info-circle iconHover" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="查看案件內容"></i>
										<i id="caseWarningIcon" class="fas fa-exclamation-circle iconHover" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="查看檢舉理由"></i>
										<i id="caseApproveIcon" class="fas fa-check-circle iconHover" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="同意該檢舉"></i>
										<i id="caseRevertIcon" class="fas fa-undo iconHover" data-whatever="<?php echo $reslutCase['c_cid']; ?>" data-toggle="tooltip" data-placement="bottom" title="撤銷該檢舉"></i>
									</div>
									<div class="noFloat"></div>
								</div>
								<div id="rightDivBody2" class="rightDivBody">
									請選擇一個案件以便觀看。
								</div>
								<div id="rightDivFooter2" class="rightDivFooter">
									<textarea id="messageArea2" class="sendArea" autocomplete="off" name="messageArea" placeholder="輸入訊息…"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<?php include "footer.php" ?>

		<!-- CaseDetail modal -->
		<link href="css/caseDetail.css" rel="stylesheet" type="text/css">
		<div id="caseModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div id="modalDiv" class="modal-content">
				</div>
			</div>
		</div>

		<!-- reportDetail modal -->
		<div id="reportModal" class="modal fade bd-example-modal-lg" tabindex="-2" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered">
				<div id="reportDiv" class="modal-content">
				</div>
			</div>
		</div>