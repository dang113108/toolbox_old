<?php
session_start();
include("../mysqli_connect.inc.php");
foreach (@$_GET as $key => $value) {
	$$key = $value;
}
$img_url = "../img/";
$category_img_url = "../icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
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
$listPageCount = ceil($resultCountCase / 10);
if (!isset($page)) {
	$page = 1;
}
?>
<table id="listTable" class="table-rwd">
	<tr class="t1 tr-only-hide">
		<th style="width: 4em;">狀態</th>
		<th style="width: 3.5em;">類型</th>
		<th>標題</th>
		<th>地址</th>
		<th>報酬</th>
		<th>截止</th>
	</tr>
	<?php
	foreach ($queryCase as $key => $value) {
		if ($key < ($page - 1) * 10) {
			continue;
		}
		$money = (string)$value['c_money'];
		$money_len = strlen($money);
		if ($money_len > 3) {
			for ($i = $money_len-3;$i > 0;$i -= 3) {
				$money = substr($money, 0, $i) . "," . substr($money, $i);
			}
		}
		?>
		<tr class="<?php if ($value['c_pid'] == @$_SESSION['userID']) { echo "indexListMyCase"; } ?>" style="cursor: pointer;" data-toggle="modal" data-target="#caseModal" data-whatever="<?php echo $value['c_cid']; ?>">
			<td data-th=""><img id="listStatusImg<?php echo $value['c_cid']; ?>" src="<?php echo $img_url . $status_array[$value['c_status']]; ?>"></td>
			<td data-th=""><img class="typeImg" src="<?php echo $category_img_url . $category_array[$value['c_category']]; ?>"></td>
			<td data-th="標題"><?php echo $value['c_title']; ?></td>
			<td data-th="地址"><?php echo $value['c_city'].$value['c_town']; ?></td>
			<td data-th="報酬">$ <?php echo $money; ?></td>
			<td data-th="截止"><?php echo $value['c_until']; ?></td>
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