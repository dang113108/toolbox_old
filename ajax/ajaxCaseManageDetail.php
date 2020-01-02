<?php
session_start();
include("../mysqli_connect.inc.php");
foreach (@$_POST as $key => $value) {
  $$key = $value;
}
foreach (@$_SESSION as $key => $value) {
  $$key = $value;
}
switch (strlen($caseID)) {
  case 1:
  $caseID0 = "00" . $caseID;
  break;
  case 2:
  $caseID0 = "0" . $caseID;
  break;
  case 3:
  $caseID0 = $caseID;
}
$img_url = "../img/";
$category_img_url = "../icon-color/";
$category_array = array("全部" => "00.png", "日常" => "01.png", "外送" => "02.png", "修繕" => "03.png", "除蟲" => "04.png", "接送" => "05.png", "課業" => "06.png", "其他" => "07.png");
$status_array = array("待接案" => "waiting.png", "進行中" => "keeping.png", "確認中" => "checking.png", "評價中" => "rating.png", "已完成" => "finished.png", "已過期" => "expired.png", "爭議中" => "fighting.png");
$selectCase = "SELECT * FROM `cases_copy` WHERE `c_cid` = '$caseID'";
$queryCase = mysqli_query($link, $selectCase);
$resultCase = mysqli_fetch_array($queryCase);
$pid = $resultCase['c_pid'];
$selectPid = "SELECT `u_nickname` from `users` where `u_uid` = '$pid'";
$queryPid = mysqli_query($link, $selectPid);
$resultPid = mysqli_fetch_array($queryPid);
$money = (string)$resultCase['c_money'];
$money_len = strlen($money);
if ($money_len > 3) {
  for ($i = $money_len-3;$i > 0;$i -= 3) {
    $money = substr($money, 0, $i) . "," . substr($money, $i);
  }
}
if ($resultCase['c_finish_end'] == '0000-00-00 00:00:00') {
  $c_finish = "該案件沒有指定完成時間。";
} else {
  $c_finish = $resultCase['c_finish_end'] . " 前";
}
if (@$userID != NULL) {
  $selectMessage = "SELECT * FROM `message` WHERE `u_uid` = '$userID' AND `c_cid` = '$caseID'";
  $queryMessage = mysqli_query($link, $selectMessage);
  $resultMessage = mysqli_fetch_array($queryMessage);
}

switch (@$resultCase['c_status']) {
  case '待接案':
  $caseStatus = "案件尚未開始。";
  break;
  case '進行中':
  $caseStatus = "等待接案人完成中。";
  break;
  case '確認中':
  $caseStatus = "等待發案人確認中。";
  break;
  case '評價中':
  $caseStatus = "等待雙方評價中。";
  break;
  case '已過期':
  $caseStatus = "此案件已經過期。";
  break;
  case '已完成':
  $caseStatus = "此案件已經完成。";
  break;
  case '爭議中':
  $caseStatus = "此案件正在調解中。";
  break;
}
?>
<div id="caseDetailDiv" class="container modalDiv">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <div class="sameline caseDetailCidBG">
    <span class="caseDetailCid"><?php echo $caseID0; ?></span>
  </div>
  <img class="sameline" src="<?php echo $category_img_url . $category_array[$resultCase['c_category']]; ?>" width="60px">
  <div class="sameline caseDetailTitle">
    <h2><?php echo $resultCase['c_title']; ?></h2>
  </div>
  <div style="clear: both;"></div>
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="container">
          <div class="row">
            <div class="col-0">
              <i class="fas fa-user caseDetailIcon"></i>
              <span class="caseDetailBasicText"><?php echo $resultPid['u_nickname']; ?></span>
            </div>
            <div class="col-0">
              <i class="fas fa-donate caseDetailIcon"></i>
              <span class="caseDetailBasicText"><?php echo $money; ?></span>
            </div>
            <div class="col-0">
              <i class="fas fa-map-marker-alt caseDetailIcon"></i>
              <span class="caseDetailBasicText">
                <?php echo $resultCase['c_city'] . $resultCase['c_town'] . $resultCase['c_road'] . $resultCase['c_address'];?>
              </span>
            </div>
          </div>
        </div>
        <table>
          <tr>
            <td width="100em" class="caseDetailBasicText caseDetailTableText">發案時間</td>
            <td class="caseDetailBasicText caseDetailTableText"><?php echo $resultCase['c_time']; ?></td>
          </tr>
          <tr>
            <td class="caseDetailBasicText caseDetailTableText">截止時間</td>
            <td class="caseDetailBasicText caseDetailTableText"><?php echo $resultCase['c_until']; ?></td>
          </tr>
          <tr>
            <td class="caseDetailBasicText caseDetailTableText">完成時間</td>
            <td class="caseDetailBasicText caseDetailTableText"><?php echo $c_finish; ?></td>
          </tr>
          <tr>
            <td class="caseDetailBasicText caseDetailTableText">案件狀態</td>
            <td id="caseStatus" class="caseDetailBasicText caseDetailTableText"><?php echo $caseStatus; ?></td>
          </tr>
        </table>
        <i class="fas fa-file-alt caseDetailIcon"></i>
        <span class="caseDetailBasicText">案件內容</span>
        <div class="box">
          <span class="caseDetailBasicText">
            <?php echo $resultCase['c_detail']; ?>
          </span>
        </div>

        <div class="accordion" id="chooseCard">
          <?php
          $selectMessage = "SELECT *,`u_nickname` FROM `message` AS `m`, `users` AS `u` WHERE `m`.`c_cid` = '$caseID' AND `m`.`u_uid` = `u`.`u_uid`";
          $queryMessage = mysqli_query($link, $selectMessage);
          while ($resultMessage = mysqli_fetch_array($queryMessage)) {
            $messageRID = $resultMessage['u_uid'];
            $selectRatySocre = "SELECT AVG(`rt_grade`) FROM `rating` WHERE `rt_rid` = '$messageRID'";
            $queryRatySocre = mysqli_query($link, $selectRatySocre);
            $resultRatySocre = mysqli_fetch_array($queryRatySocre);?>
            <div class="card cardMessage">
              <div class="card-header cardMessageHeader" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link cardBtn width100" data-toggle="collapse" data-target="#collapse<?php echo $resultMessage['m_mid']; ?>" aria-expanded="true" aria-controls="collapseOne">
                    <div class="caseQnAText sameline">
                      <?php echo $resultMessage['u_nickname']; ?>
                    </div>
                    <div class="caseQnADate">
                      <?php for ($i=1; $i < 6; $i++) {
                        if ($i > $resultRatySocre[0]) {?>
                          <img src="img/raty/star-off.png">
                        <?php } else { ?>
                          <img src="img/raty/star-on.png">
                        <?php } } ?>
                      </div>
                      <div style="clear: both;"></div>
                    </button>
                  </h5>
                </div>
                <div id="collapse<?php echo $resultMessage['m_mid']; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                  <div class="card-body">
                    <?php echo $resultMessage['m_message']; ?>
                  </div>
                  <div class="card-footer text-muted cardCustFooter">
                    <div class="caseQnAText">
                      <?php echo $resultMessage['m_time'] . " 截止"; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="col qnaBigDiv">
          <div class="qnaTitle text-center">問 與 答</div>
          <div id="qnaTable" class="qnaTable">
            <?php
            $selectQuestion = "SELECT * FROM `qanda` WHERE `q_cid` = '$caseID' ORDER BY `q_created_at` DESC";
            $queryQuestion = mysqli_query($link, $selectQuestion);
            while ($resultQuestion = mysqli_fetch_array($queryQuestion)) {
              $u_name = $resultQuestion['q_pid'];
              $selectName = "SELECT `u_nickname` FROM `users` WHERE `u_uid` = '$u_name'";
              $queryName = mysqli_query($link, $selectName);
              $resultName = mysqli_fetch_array($queryName);
              $u_name = $resultName['u_nickname'];
              ?>
              <div class="card cardMessage">
                <div class="card-header cardMessageHeader questionHeader" id="headingTwo">
                  <h5 class="mb-0">
                    <button class="btn btn-link cardBtn width100 questionHeaderText" data-toggle="collapse" data-target="#collapseQ<?php echo $resultQuestion['q_qid']; ?>" aria-expanded="true" aria-controls="collapseOne">
                      <div class="text-left">
                        <div id="answerIcon<?php echo $resultQuestion['q_qid']; ?>">
                          <?php if ($resultQuestion['q_atext'] != NULL) { ?>
                            <i class="fas fa-user-check qnaAnswered sameline"></i>
                          <?php } else { ?>
                            <i class="fas fa-user-times qnaNotAnswered sameline"></i>
                          <?php } ?>
                        </div>
                        <div class="caseQnAText sameline"><?php echo $u_name; ?></div><div class="caseQnADate"><?php echo $resultQuestion['q_created_at']; ?></div>
                        <div style="clear: both;"></div>
                      </div>
                    </button>
                  </h5>
                </div>
                <div id="collapseQ<?php echo $resultQuestion['q_qid']; ?>" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                  <div class="card-body">
                    <?php echo $resultQuestion['q_ptext']; ?>
                  </div>
                  <div class="card-footer text-muted cardCustFooter">
                    <div class="text-left">
                      <div class="caseQnADate"><?php echo $resultQuestion['q_updated_at']; ?></div>
                      <div style="clear: both;"></div>
                    </div>
                    <div class="caseQnAText">
                      <?php echo $resultQuestion['q_atext']; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>