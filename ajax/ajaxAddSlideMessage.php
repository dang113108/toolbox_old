<?php
session_start();
include("../mysqli_connect.inc.php");
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$selectCase = "SELECT * FROM `cases` WHERE `c_cid` = $caseID";
$queryCase = mysqli_query($link, $selectCase);
$resultCase = mysqli_fetch_array($queryCase);
$img_url = "img/";
$category_img_url = "icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
?>
<div class="card slideCardBody" style="cursor: pointer;" onclick="showMessage(<?php echo $caseID . ",'" . $resultCase['c_title'] . "'" . ",'" . $userName . "'"; ?>);">
	<div class="row text-left">
		<div class="col-5"><img src="<?php echo $img_url . $status_array['進行中']; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$resultCase['c_category']]; ?>"></div>
		<div class="col-"><?php echo $resultCase['c_title']; ?></div>
		<div class="w-100"></div>
		<div class="col-5">NT$ <?php echo $resultCase['c_money']; ?></div>
		<div class="col-"><?php echo $resultCase['c_city'] . $resultCase['c_town'] . $resultCase['c_road']; ?></div>
	</div>
	<span class="messageNotifyChat" style="display: inline-block;" id="messageNotifyChat<?php echo $caseID; ?>"></span>
	<div id="messageNotifyChatCount<?php echo $caseID; ?>" style="display: none;">1</div>
</div>