<?php
session_start();
include("mysqli_connect.inc.php");
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
foreach (@$_POST as $key => $value) {
	$$key = $value;
}
$img_url = "img/";
$category_img_url = "icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
if (@$slideCategory == "") {
	$selectRaty = "SELECT * FROM `rating` WHERE `rt_rid` = '$userID' ORDER BY `rt_id` DESC";
} else {
	$selectRaty = "SELECT * FROM `rating` WHERE `rt_rid` = '$userID' AND `rt_category` = '$slideCategory' ORDER BY `rt_id` DESC";
}
$queryRaty = mysqli_query($link, $selectRaty);
while (@$resultRaty = mysqli_fetch_array($queryRaty)) {
	$caseID = $resultRaty['rt_cid'];
	$selectPost = "SELECT *, `u_nickname` FROM `cases_copy`, `users` WHERE `cases_copy`.`c_cid` = '$caseID' AND `cases_copy`.`c_pid` = '$userID' AND `cases_copy`.`c_rid` = `users`.`u_uid`";
	$queryPost = mysqli_query($link, $selectPost);
	$resultPost = mysqli_fetch_array($queryPost);
	if ($resultPost['c_cid'] != "") {
		?>
		<div class="card cardMessage">
			<div class="card-header cardMessageHeader questionHeader">
				<h5 class="mb-0">
					<button class="btn btn-link cardBtn width100 questionHeaderText" data-toggle="collapse" data-target="#raty<?php echo $resultRaty['rt_id']; ?>" aria-expanded="true" aria-controls="collapseOne">
						<div class="text-left">
							<div class="sameline">
								<img class="slideImg" src="<?php echo $category_img_url . $category_array[$resultPost['c_category']]; ?>">
							</div>
							<div class="caseQnAText sameline"><?php echo $resultPost['u_nickname']; ?></div>
							<div class="caseQnADate">
								<?php for ($i=1; $i < 6; $i++) {
									if ($i > $resultRaty['rt_grade']) {?>
										<img src="img/raty/star-off.png">
									<?php } else { ?>
										<img src="img/raty/star-on.png">
									<?php } } ?>
								</div>
								<div style="clear: both;"></div>
							</div>
						</button>
					</h5>
				</div>
				<div id="raty<?php echo $resultRaty['rt_id']; ?>" class="collapse" data-parent="#accordion">
					<div class="card-body">
						<?php echo $resultRaty['rt_content']; ?>
					</div>
					<div class="card-footer text-muted cardCustFooter">
						<div class="text-left">
							<div class="caseQnADate"><?php echo $resultRaty['rt_time']; ?></div>
							<div style="clear: both;"></div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	?>