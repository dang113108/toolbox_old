<?php
session_start();
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$img_url = "img/";
$category_img_url = "icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
?>
<div class="card slideCardBody" style="cursor: pointer;" onclick="showMessage(<?php echo $caseID . ",'" . $title . "'" . ",'" . $userName . "'"; ?>);">
	<div class="row text-left">
		<div class="col-5"><img src="<?php echo $img_url . $status_array['進行中']; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$category]; ?>"></div>
		<div class="col-7 messageTitle"><?php echo $title; ?></div>
		<div class="w-100"></div>
		<div class="col-5">NT$ <?php echo $money; ?></div>
		<div class="col-7 messageTitle"><?php echo $address; ?></div>
	</div>
	<span class="messageNotifyChat" id="messageNotifyChat<?php echo $caseID; ?>"></span>
	<div id="messageNotifyChatCount<?php echo $caseID; ?>" style="display: none;">0</div>
</div>