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
$selectReport = "SELECT * FROM `report` WHERE `rp_cid` = '$caseID'";
$queryReport = mysqli_query($link, $selectReport);
?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
<div class="accordion" id="accordionExample">
  <?php while ($resultReport = mysqli_fetch_array($queryReport)) { ?>
    <div class="card cardMessage">
      <div class="card-header cardMessageHeader" id="headingOne">
        <h5 class="mb-0">
          <button class="btn btn-link cardBtn width100" data-toggle="collapse" data-target="#collapse<?php echo $resultReport['rp_rpid']; ?>" aria-expanded="true" aria-controls="collapseOne">
            <div class="caseQnAText sameline">
              <?php echo $resultReport['rp_type']; ?>
            </div>
            <div class="caseQnADate">
              <?php echo $resultReport['rp_created']; ?>
            </div>
            <div style="clear: both;"></div>
          </button>
        </h5>
      </div>
      <div id="collapse<?php echo $resultReport['rp_rpid']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
        <div class="card-body">
          <?php echo $resultReport['rp_content']; ?>
        </div>
      </div>
    </div>
  <?php } ?>
</div>