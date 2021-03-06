<?php
session_start();
include("mysqli_connect.inc.php");
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
$selectGet = "SELECT * FROM `cases` WHERE `c_cid` = '$caseID'";
$queryGet = mysqli_query($link, $selectGet);
$resultGet = mysqli_fetch_array($queryGet);?>
<div class="card slideCardBody" style="cursor: pointer;" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $resultGet['c_cid']; ?>">
	<div class="row text-left">
		<div class="col-5"><img src="<?php echo $img_url . $status_array[$resultGet['c_status']]; ?>"><img class="typeImg" src="<?php echo $category_img_url . $category_array[$resultGet['c_category']]; ?>"></div>
		<div class="col-"><?php echo $resultGet['c_title']; ?></div>
		<div class="w-100"></div>
		<div class="col-5">NT$ <?php echo $resultGet['c_money']; ?></div>
		<div class="col-"><?php echo $resultGet['c_city'] . $resultGet['c_town'] . $resultGet['c_road']; ?></div>
	</div>
</div>