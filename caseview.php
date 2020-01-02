<?php
set_time_limit(0);
session_start();
if (isset($_GET['keyword'])) {
	$keyword = $_GET['keyword'];
} else {
	$keyword = "";
}
if (isset($_GET['type'])) {
	$category = $_GET['type'];
} else {
	$category = "全部";
}
if (isset($_GET['code'])) {
	$verifyCode = $_GET['code'];
} else {
	$verifyCode = 'NoCode';
}
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>檢視案件 - ToolBox</title>
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
	<script src="js/kendo.all.min.js"></script>
	<script src="js/index.js"></script>
	<script src="js/totop.js"></script>
	<script>
		var category = '<?php echo $category; ?>';
		var keyword = '<?php echo $keyword; ?>';
		var verifyCode = '<?php echo $verifyCode; ?>';
		var messageName = '<?php echo @$userName; ?>';
		var messageImg = '<?php echo @$userImg; ?>';
	</script>
</head>
<body data-offset="60" data-spy="scroll" data-target=".navbar" id="myPage">
	<?php
	include "nav.php"; // 匯入上面導航欄
	include "mysqli_connect.inc.php";
	include "testArray.php";
	//------------------------變數區
	$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png");
	$type_class_array = array("日常" => "normal", "外送" => "sendout", "修繕" => "fix", "除蟲" => "bug", "接送" => "transfer", "課業" => "homework");
	//------------------------BODY區
	?>
	<div id="mainDiv" align="center" class="container-fluid body_div" id="sta">
		<nav>
			<div class="nav nav-tabs justify-content-end" id="nav-tab" role="tablist">
				<?php foreach ($category_array as $key => $value) { ?>
					<button onclick="chooseType('<?php echo $key; ?>');" class="nav-item nav-link themeBGColor searchBtn indexTypeButton sameline <?php echo $type_class_array[$key]; ?>"><?php echo $key; ?></button>
				<?php } ?>
				<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">格狀檢視</a>
				<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">列表檢視</a>
			</div>
		</nav>
		<br>
		<div class="tab-content" id="nav-tabContent">
			<!-- 下面是格狀檢視 -->
			<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
			</div>
			<!-- 上面是格狀檢視 -->
			<!-- 下面是列表檢視 -->
			<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
			</div>
			<!-- 上面是列表檢視 -->
		</div>
	</div>
	<?php if (@$userID != NULL && @$verify != "未驗證") {?>
		<!-- 新增案件Btn -->
		<div id="addCaseBtn" class="addCaseBtn" data-toggle="tooltip" data-placement="left" title="發布案件">
			<img id="addCaseBtn"class="addCaseImg" src="img/hire.png">
		</div>
		<!-- 新增案件Btn -->
		<!-- 緊急聯絡Btn -->
		<div id="emergencyBtn" class="emergencyBtn" data-html="true" data-toggle="popover" data-placement="left" title="緊急按鈕" data-content="<div><button class='btn btn-primary sumbitEmergency' onclick='callEmergency();'>我遭遇緊急情況</button></div><div style='font-size: 8px;'>按下此鈕後會立即發送簡訊給您的<br>緊急聯絡人：陳宏明<br>電話號碼：0919038457<br>並向您收取簡訊費用，<br>非緊急情況請勿隨意點擊。</div>">
			<img id="emergencyBtn"class="emergencyImg" src="img/emergency.png">
		</div>
		<!-- 緊急聯絡Btn -->
	<?php } ?>

	<!-- 吐司 -->
	<div id="snackbar"></div>

	<!-- AddCase modal -->
	<div id="addCaseNoticeModal" class="modal fade bd-example-modal-sm" tabindex="-3" role="dialog" aria-labelledby="addCaseNoticeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered">
			<div id="addCaseNoticeModalDiv" class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">與工具人的契約</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p>
						一、禁止欺騙、騷擾以及傷害雇主/勞方之行為，勞方以達成雇主所提之案件為最終目的。例如：接案後故意與案件目標條件相差異之行為；利用聊天室功能對雇主/勞方進行騷擾行為等。
					</p>
					<p>
						二、禁止額外要求勞方進行已約定案件外之事項，若勞方口頭上或利用訊息應允，勞方須自行負責。
					</p>
					<p>
						三、勞方為未成年人時，依民法第 79 條規定，限制行為能力人，為意思表示及受意思表示，應得法定代理人之允許，未得法定代理人允許所訂立之契約，頇經法定代理人之承認，始生效力。另依勞動基準法第 46 條規定，未滿 18 歲之人受僱從事工作者，雇主應置備其法定代理人同意書及其年齡證書文件。
					</p>
					<p>
						四、雇主進行發案時，其內容應合理且清楚列出實際需求及工作性質，並斟酌慎選進行交易之地點。
					</p>
					<p>
						五、勞動契約之工作項目採列舉方式訂明，其內容勞方應視工作技能及意願去配合，若雙方均同意此案件，勞方應履行其義務直至目標達成為止
					</p>
					<p>
						六、雇主訂定之金額純指予以勞方的報酬，並不包含雇主所需求之物品價格，且不可隨意刪減。
					</p>
					<p>
						當事人在契約締結前為避免權益受損,應各自盡力充分調查與契約締結有關之事宜,故前契約階段有關之說明或資訊危險,當事人自應各自承擔與各自負責。
					</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">我不同意</button>
					<button id="agreeToAddCase" type="button" class="btn btn-primary">我同意</button>
				</div>
			</div>
		</div>
	</div>

	<!-- AddCase modal -->
	<div id="addCaseModal" class="modal fade bd-example-modal-sm" tabindex="-2" role="dialog" aria-labelledby="addCaseModalLabel" aria-hidden="true" data-backdrop="static">
		<div class="modal-dialog modal-sm modal-dialog-centered">
			<div id="addCaseModalDiv" class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">招募工具人</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addCaseForm" class="form-group">
					<div class="modal-body">
						<div class="form-group row">
							<label for="c_category" class="col-sm-2 col-form-label">類型</label>
							<div class="col-sm-8 citySelect">
								<select id="c_category" name="c_category" class="form-control">
									<option value="日常" selected>日常</option>
									<option value="接送">接送</option>
									<option value="外送">外送</option>
									<option value="課業">課業</option>
									<option value="修繕">修繕</option>
									<option value="除蟲">除蟲</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="c_title" class="col-sm-2 col-form-label">標題</label>
							<div class="col-sm-8 citySelect">
								<input type="text" class="form-control" id="c_title" name="c_title" placeholder="請幫我倒垃圾！" value="搬完宿舍幫掃地">
							</div>
						</div>
						<div class="form-group row">
							<label for="c_money" class="col-sm-2 col-form-label">酬勞</label>
							<div class="col-sm-8 citySelect">
								<input type="number" class="form-control" id="c_money" name="c_money" placeholder="最低金額: 20元" value="50">
							</div>
						</div>
						<div class="form-group row">
							<label for="c_city" class="col-sm-2 col-form-label">工作地點</label>
							<div class="col-sm-2 citySelect">
								<select id="c_city" name="c_city" class="form-control roadSelect">
									<option value="台中市" selected>台中市</option>
								</select>
							</div>
							<div class="col-sm-3 roadSelect">
								<select id="c_town" name="c_town" class="form-control roadSelect">
									<?php foreach ($addressArray as $key => $value) { ?>
										<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3 roadSelect">
								<select id="c_road" name="c_road" class="form-control roadSelect">
									<?php foreach ($addressArray['中區'] as $value) { ?>
										<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group row marginUnset">
							<label for="c_address" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-8 citySelect">
								<input type="text" class="form-control" id="c_address" name="c_address" placeholder="市府北七路123號" value="中正路57-1號">
							</div>
						</div>
						<div class="form-group row">
							<label for="c_detail" class="col-sm-2 col-form-label">工作內容</label>
							<div class="col-sm-8 citySelect">
								<textarea class="form-control" id="c_detail" name="c_detail" placeholder="輸入詳細的工作內容">剛搬完宿舍需要人來掃地~
徵求一位細心的人
謝謝！</textarea>
							</div>
						</div>
						<div class="form-group row marginUnset">
							<label for="c_hour" class="col-sm-2 col-form-label">案件效期</label>
							<div class="col-sm-3 citySelect">
								<select id="c_hour" name="c_hour" class="form-control roadSelect">
									<?php for ($hour = 0; $hour < 24; $hour++) { ?>
										<option value="<?php echo $hour; ?>"><?php echo $hour; ?> 小時</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3 citySelect">
								<select id="c_mins" name="c_mins" class="form-control roadSelect">
									<?php for ($mins = 0; $mins < 60; $mins++) { ?>
										<option value="<?php echo $mins; ?>"><?php echo $mins; ?> 分鐘</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-2 citySelect">
								後過期
							</div>
						</div>
						<div class="row">
							<legend class="col-form-label col-sm-2 pt-0">完成時間</legend>
							<div class="col-sm-10">
								<div class="form-check">
									<label class="form-check-label" for="gridRadios1">
										<input class="form-check-input" type="radio" name="c_finish_end" id="c_finish_end1" value="不設定" checked>
										不設定
									</label>
								</div>
								<div class="form-check">
									<label class="form-check-label" for="gridRadios2">
										<input class="form-check-input" type="radio" name="c_finish_end" id="c_finish_end2" value="設定時間">
										設定完成案件期限
									</label>
								</div>
							</div>
						</div>
						<div id="c_finish_div" class="form-group row" style="display: none;">
							<label for="c_finish_hour" class="col-sm-2 col-form-label"></label>
							<div class="col-sm-3 citySelect">
								<input id="datetimepicker" name = "settime" class="form-control" />
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">不招了啦</button>
						<button id="checkAddCase" type="submit" class="btn btn-primary">我要招</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- CaseDetail modal -->
	<link href="css/caseDetail.css" rel="stylesheet" type="text/css">
	<div id="caseModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div id="modalDiv" class="modal-content">
			</div>
		</div>
	</div>

	<!-- RatyDetail modal -->
	<div id="ratyModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div id="ratyModalDiv" class="modal-content">
			</div>
		</div>
	</div>


	<!-- 吐司 -->
	<div id="snackbar"></div>

	<script src="js/chooseTime.js"></script>
	<script src="js/indexPage.js"></script>