<?php
session_start();
include("../mysqli_connect.inc.php");
foreach (@$_GET as $key => $value) {
	$$key = $value;
}
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
$img_url = "../img/";
$category_img_url = "../icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
$status_class_array = array("待接案" => "waiting", "進行中" => "keeping", "確認中" => "checking", "評價中" => "rating", "已完成" => "finished", "已過期" => "expired", "爭議中" => "fighting");
if ($type == "全部") {
	if (@$keyword == NULL) {
		$selectCase = "SELECT * FROM `cases` ORDER BY `c_cid` DESC";
	} else {
		$selectCase = "SELECT * FROM `cases` where ((`c_title` LIKE '%$keyword%') or (`c_detail` LIKE '%$keyword%') or (`c_town` LIKE '%$keyword%') or (`c_road` LIKE '%$keyword%')) order by c_cid desc";
	}
} else {
	if (@$keyword == NULL) {
		$selectCase = "SELECT * FROM `cases` WHERE `c_category` = '$type' ORDER BY `c_cid` DESC";
	} else {
		$selectCase = "SELECT * FROM `cases` WHERE `c_category` = '$type' AND ((`c_title` LIKE '%$keyword%') or (`c_detail` LIKE '%$keyword%') or (`c_town` LIKE '%$keyword%') or (`c_road` LIKE '%$keyword%')) order by c_cid desc";
	}
}
$queryCase = mysqli_query($link, $selectCase);
$resultCountCase = mysqli_num_rows($queryCase);
$gridPageCount = ceil($resultCountCase / 6);
if (!isset($page)) {
	$page = 1;
}
$div_count = 1;
foreach ($queryCase as $key => $value) {
	if ($key < ($page - 1) * 6) {
		continue;
	}
	$money = (string)$value['c_money'];
	$money_len = strlen($money);
	if ($money_len > 3) {
		for ($i = $money_len-3;$i > 0;$i -= 3) {
			$money = substr($money, 0, $i) . "," . substr($money, $i);
		}
	}
	if ($div_count % 3 == 1) {
		echo '<div id="gridDiv" class="card-deck text-center col-xs-12 indexGridCard">';
	}
	?>
	<div class="card gridCard">
		<div id="gridStatusDiv<?php echo $value['c_cid']; ?>" class="card-header <?php echo $status_class_array[$value['c_status']]; ?>"><?php echo $value['c_status']; ?></div>
		<div class="card-header">
			<h5 class="card-title gridText"><?php echo $value['c_title']; ?></h5>
			<h6 class="card-title">
				<?php if ($value['c_pid'] == @$userID || $value['c_rid'] == @$userID) { ?>
					<i class="far fa-address-card gridMyCase"></i>
				<?php } ?>
				<?php echo $value['c_category']; ?>
			</h6>
		</div>
		<div class="card-footer  bg-transparent">
			<p class="card-text gridDetail"><?php echo $value['c_detail']; ?></p>
			<h7 class="card-title"><?php echo $value['c_city'].$value['c_town']; ?></h7>
		</div>
		<div class="card-footer  bg-transparent">
			<h3>NT$ <?php echo $money; ?></h3>
			<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $value['c_cid']; ?>">查看</button>
		</div>
		<div class="card-footer">
			<small class="text-muted"><?php echo $value['c_until']; ?> 截止</small>
		</div>
	</div>
	<?php
	if ($div_count % 3 == 0 || $key == $resultCountCase - 1) {
		echo '</div>';
	}
	$div_count++;
	if ($key == (($page - 1) * 6 + 5)) {
		break;
	}
} ?>
<br id="gridBr">
<nav id="gridNav" aria-label="Page navigation example">
	<ul class="pagination justify-content-center">
		<?php for ($value = 1; $value <= $gridPageCount; $value++) { ?>
			<li class="page-item gridCase <?php if ($value == $page) { echo "active"; } ?>"><a class="page-link"><?php echo $value; ?></a></li>
		<?php } ?>
	</ul>
</nav>