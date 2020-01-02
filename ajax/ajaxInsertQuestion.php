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
$question = nl2br($question);
$selectTime = "SELECT CURRENT_TIMESTAMP";
$queryTime = mysqli_query($link, $selectTime);
$resultTime = mysqli_fetch_array($queryTime);
$insertQnA = "INSERT INTO `qanda` (`q_qid`, `q_cid`, `q_pid`, `q_aid`, `q_ptext`, `q_created_at`, `q_updated_at`) VALUES (NULL, '$caseID', '$userID', '$postID', '$question', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
if (mysqli_query($link, $insertQnA)) {
	$lastID = mysqli_insert_id($link);
	?>
	<div class="card cardMessage">
		<div class="card-header cardMessageHeader questionHeader" id="headingTwo">
			<h5 class="mb-0">
				<button class="btn btn-link cardBtn width100 questionHeaderText" data-toggle="collapse" data-target="#collapseQ<?php echo $lastID; ?>" aria-expanded="true" aria-controls="collapseOne">
					<div class="text-left">
						<i class="fas fa-user-times qnaNotAnswered sameline"></i>
						<div class="caseQnAText sameline"><?php echo $userNickName; ?></div><div class="caseQnADate"><?php echo $resultTime[0]; ?></div>
						<div style="clear: both;"></div>
					</div>
				</button>
			</h5>
		</div>
		<div id="collapseQ<?php echo $lastID; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
			<div class="card-body">
				<?php echo $question; ?>
			</div>
			<div class="card-footer text-muted cardCustFooter">
			</div>
		</div>
	</div>
	<?php } ?>