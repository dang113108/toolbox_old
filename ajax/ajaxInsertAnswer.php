<?php
session_start();
include("../mysqli_connect.inc.php");
if (@$_SESSION['userAccount'] == NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
$selectTime = "SELECT CURRENT_TIMESTAMP";
$queryTime = mysqli_query($link, $selectTime);
$resultTime = mysqli_fetch_array($queryTime);
$insertQnA = "UPDATE `qanda` SET `q_atext` = '$q_atext', `q_updated_at` = CURRENT_TIMESTAMP WHERE `q_qid` = '$q_qid'";
if (mysqli_query($link, $insertQnA)) { ?>
	<div class="text-left">
		<div class="caseQnADate"><?php echo $resultTime[0]; ?></div>
		<div style="clear: both;"></div>
	</div>
	<div class="caseQnAText">
		<?php echo $q_atext; ?>
	</div>
	<?php } ?>