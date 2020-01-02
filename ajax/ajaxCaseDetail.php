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
$cBtnText = "收藏";
$cBtnStatus = "";
$gBtnStatus = "";
$rBtnStatus = "";
$aBtnStatus = "";
$askBtnStatus = "";
$overBtnStatus = "";
$reverBtnStatus = "";
$rRatingBtnStatus = "disabled";
$pRatingBtnStatus = "disabled";
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
  $selectCollect = "SELECT * FROM `collection` WHERE `u_uid` = '$userID' AND `c_cid` = '$caseID'";
  $queryCollect = mysqli_query($link, $selectCollect);
  $resultCollect = mysqli_fetch_array($queryCollect);

  $selectMessage = "SELECT * FROM `message` WHERE `u_uid` = '$userID' AND `c_cid` = '$caseID'";
  $queryMessage = mysqli_query($link, $selectMessage);
  $resultMessage = mysqli_fetch_array($queryMessage);

  $selectReport = "SELECT * FROM `report` WHERE `rp_uid` = '$userID' AND `rp_cid` = '$caseID'";
  $queryReport = mysqli_query($link, $selectReport);
  $resultReport = mysqli_fetch_array($queryReport);

  if (@$resultCollect['u_uid'] == @$userID) {
    $cBtnText = "取消";
  }

  if (@$resultMessage['m_mid'] != NULL) {
    $gBtnStatus = "disabled";
  }
}

if (@$resultCase['c_status'] != "進行中") {
  $askBtnStatus = "disabled";
}

if (@$resultCase['c_status'] != "確認中") {
  $overBtnStatus = "disabled";
  $reverBtnStatus = "disabled";
}

if (@$resultCase['c_status'] == "評價中") {
  $selectRating = "SELECT * FROM `rating` WHERE `rt_cid` = '$caseID'";
  $queryRating = mysqli_query($link, $selectRating);
  $resultRating = mysqli_fetch_array($queryRating);
  $rRatingBtnStatus = "";
  $pRatingBtnStatus = "";
  if ($resultRating['rt_pid'] == @$userID) {
    $pRatingBtnStatus = "disabled";
    $rRatingBtnStatus = "disabled";
  }
}

if (@$resultCase['c_status'] != "待接案" || @$resultCase['c_rid'] == @$userID || @$userID == NULL) {
  $cBtnStatus = "disabled";
  $gBtnStatus = "disabled";
  $aBtnStatus = "disabled";
}

if (@$resultReport['rp_uid'] != "") {
  $rBtnStatus = "disabled";
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
$selectRatyPost = "SELECT AVG(`rt_grade`) FROM `rating` WHERE `rt_pid` = '$pid'";
$queryRatyPost = mysqli_query($link, $selectRatyPost);
$resultRatyPost = mysqli_fetch_array($queryRatyPost);
?>
<div id="caseDetailDiv" class="container modalDiv">
  <script src="../js/caseDetail.js"></script>
  <script type="text/javascript">
    var userID = <?php echo $userID; ?>;
    var caseID = <?php echo $caseID; ?>;
  </script>
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
<!--             <div class="col-0">
              <i class="fas fa-user caseDetailIcon"></i>
              <span class="caseDetailBasicText"><?php # echo $resultPid['u_nickname']; ?></span>
            </div> -->
            <div class="col-0">
              <i class="fas fa-donate caseDetailIcon"></i>
              <span class="caseDetailBasicText"><?php echo $money; ?></span>
            </div>
            <div class="col-0">
              <i class="fas fa-map-marker-alt caseDetailIcon"></i>
              <span class="caseDetailBasicText">
                <?php echo $resultCase['c_city'] . $resultCase['c_town']; ?><?php if ($resultCase['c_pid'] == @$userID || $resultCase['c_rid'] == @$userID) { echo $resultCase['c_road'] . $resultCase['c_address']; }?>
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
          <tr>
            <td class="caseDetailBasicText caseDetailTableText">雇主評價</td>
            <td class="caseDetailBasicText caseDetailTableText">
              <?php for ($i=1; $i < 6; $i++) {
                if ($i > $resultRatyPost[0]) {?>
                  <img src="img/raty/star-off.png">
                <?php } else { ?>
                  <img src="img/raty/star-on.png">
                <?php } } ?>
              </td>
            </tr>
          </table>
          <i class="fas fa-file-alt caseDetailIcon"></i>
          <span class="caseDetailBasicText">案件內容</span>
          <div class="box">
            <span class="caseDetailBasicText">
              <?php echo $resultCase['c_detail']; ?>
            </span>
          </div>

          <div id="waitBtnDiv" class="caseDetailButtonDiv text-center">
            <?php if ($resultCase['c_status'] != '待接案' && $resultCase['c_rid'] == @$userID) { ?>
              <button id="askToCheck" data-cid="<?php echo $resultCase['c_cid']; ?>" data-status="確認中" data-pid="<?php echo $resultCase['c_pid']; ?>" class="caseDetailButton" <?php echo $askBtnStatus; ?>>
                <i class="fas fa-check-circle"></i>
                <span class="caseDetailButtonText">完成</span>
              </button>
              <button id="ratingToCheck" data-cid="<?php echo $resultCase['c_cid']; ?>" data-rid="<?php echo $resultCase['c_rid']; ?>" data-status="" class="caseDetailButton" <?php echo $rRatingBtnStatus; ?>>
                <i class="fas fa-grin-alt"></i>
                <span class="caseDetailButtonText">評價</span>
              </button>
            <?php } else if ($resultCase['c_pid'] == @$userID) { ?>
              <button id="overToCheck" data-cid="<?php echo $resultCase['c_cid']; ?>" data-status="評價中" data-pid="<?php echo $resultCase['c_pid']; ?>" data-rid="<?php echo $resultCase['c_rid']; ?>" class="caseDetailButton" <?php echo $overBtnStatus; ?>>
                <i class="fas fa-check-circle"></i>
                <span class="caseDetailButtonText">結案</span>
              </button>
              <button id="reverToCheck" data-cid="<?php echo $resultCase['c_cid']; ?>" data-status="進行中" class="caseDetailButton" <?php echo $reverBtnStatus; ?>>
                <i class="fas fa-times-circle"></i>
                <span class="caseDetailButtonText">退回</span>
              </button>
              <button id="ratingToCheck" data-cid="<?php echo $resultCase['c_cid']; ?>" data-pid="<?php echo $resultCase['c_pid']; ?>" data-status="已完成" class="caseDetailButton" <?php echo $pRatingBtnStatus; ?>>
                <i class="fas fa-grin-alt"></i>
                <span class="caseDetailButtonText">評價</span>
              </button>
            <?php } else if ($resultCase['c_rid'] != @$userID) { ?>
              <button id="colBtn" class="caseDetailButton" <?php echo $cBtnStatus; ?>>
                <i class="fas fa-star white"></i>
                <span id="colText" class="caseDetailButtonText"><?php echo $cBtnText; ?></span>
              </button>
              <button id="getBtn" class="caseDetailButton" <?php echo $gBtnStatus; ?>>
                <i class="fas fa-check white"></i>
                <span class="caseDetailButtonText">接案</span>
              </button>
              <button id="askBtn" class="caseDetailButton" <?php echo $aBtnStatus; ?>>
                <i class="fas fa-question white"></i>
                <span class="caseDetailButtonText">提問</span>
              </button>
            <?php } ?>
            <?php if ($resultCase['c_pid'] != @$userID) { ?>
              <button id="repBtn" class="caseDetailButton" <?php echo $rBtnStatus; ?>>
                <i class="fas fa-exclamation white"></i>
                <span class="caseDetailButtonText">檢舉</span>
              </button>
            <?php } ?>
          </div>

          <?php if ($resultCase['c_pid'] == @$_SESSION['userID'] && $resultCase['c_status'] == "待接案") { ?>
            <div class="accordion" id="chooseCard">
              <?php
              $selectMessage = "SELECT *,`u_nickname` FROM `message` AS `m`, `users` AS `u` WHERE `m`.`c_cid` = '$caseID' AND `m`.`u_uid` = `u`.`u_uid`";
              $queryMessage = mysqli_query($link, $selectMessage);
              while ($resultMessage = mysqli_fetch_array($queryMessage)) {
                $messageRID = $resultMessage['u_uid'];
                $selectRatySocre = "SELECT AVG(`rt_grade`) FROM `rating` WHERE `rt_rid` = '$messageRID'";
                $queryRatySocre = mysqli_query($link, $selectRatySocre);
                $resultRatySocre = mysqli_fetch_array($queryRatySocre);
                ?>
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
                        <div class="caseQnAText sameline">
                          <?php echo $resultMessage['m_time'] . " 截止"; ?>
                        </div>
                        <div class="caseQnADate">
                          <button data-msgId="<?php echo $resultMessage['m_mid']; ?>" data-caseId="<?php echo $resultCase['c_cid']; ?>" data-taskerId="<?php echo $resultMessage['u_uid']; ?>" class="btn btn-primary smallFont marginUnset chooseToolMan">選定工具人</button>
                        </div>
                        <div style="clear: both;"></div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            <?php } else { ?>
              <div id="qnaDiv" class="qnaDiv">
                <form id="questionForm" name="questionForm" class="text-right">
                  <input name="postID" type="hidden" value="<?php echo $resultCase['c_pid']; ?>">
                  <input name="caseID" type="hidden" value="<?php echo $caseID; ?>">
                  <input name="userID" type="hidden" value="<?php echo $userID; ?>">
                  <textarea id="question" name="question" placeholder="問我一些問題吧！"></textarea>
                  <button id="submitQuestion" class="caseDetailButton">
                    <i class="far fa-comment-dots"></i>
                    <span class="caseDetailButtonText">送出</span>
                  </button>
                </form>
              </div>
              <div id="getDiv" class="qnaDiv">
                <form id="getCaseForm" name="questionForm" class="text-right">
                  <input id="getCaseID" name="caseID" type="hidden" value="<?php echo $caseID; ?>">
                  <input name="userID" type="hidden" value="<?php echo $userID; ?>">
                  <input id="getPostID" name="postID" type="hidden" value="<?php echo $resultCase['c_pid']; ?>">
                  <textarea id="message" name="message" placeholder="向發案人說一些話吧！"></textarea>
                  <div class="form-group row">
                    <div class="col-sm-3">申請效期</div>
                    <div class="col-sm-3">
                      <select id="c_hour" name="c_hour" class="form-control">
                        <?php for ($hour = 0; $hour < 24; $hour++) { ?>
                          <option value="<?php echo $hour; ?>"><?php echo $hour; ?> 小時</option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-3">
                      <select id="c_mins" name="c_mins" class="form-control">
                        <?php for ($mins = 0; $mins < 60; $mins++) { ?>
                          <option value="<?php echo $mins; ?>"><?php echo $mins; ?> 分鐘</option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-sm-2 citySelect">後過期</div>
                  </div>
                  <button id="submitGetCase" class="caseDetailButton">
                    <i class="far fa-comment-dots"></i>
                    <span class="caseDetailButtonText">申請</span>
                  </button>
                </form>
              </div>
              <div id="ratyDiv" class="qnaDiv">
                <form id="ratyForm" name="ratyForm" class="text-right">
                  <input id="ratyPostID" name="postID" type="hidden" value="<?php echo $resultCase['c_pid']; ?>">
                  <input id="ratyReciID" name="reciID" type="hidden" value="<?php echo $resultCase['c_rid']; ?>">
                  <input id="ratyCaseID" name="caseID" type="hidden" value="<?php echo $caseID; ?>">
                  <input name="category" type="hidden" value="<?php echo $resultCase['c_category']; ?>">
                  <input id="ratyResult" name="ratyResult" type="hidden" required="true">
                  <div id="rating"></div>
                  <textarea id="ratyContent" name="ratyContent" placeholder="輸入對此次案件的評價！">很棒的案件體驗！</textarea>
                  <button type="submit" id="submitRaty" class="caseDetailButton">
                    <i class="far fa-comment-dots"></i>
                    <span class="caseDetailButtonText">評價</span>
                  </button>
                </form>
              </div>
              <div id="reportDiv" class="qnaDiv">
                <form id="reportForm" name="ratyForm">
                  <input name="postID" type="hidden" value="<?php echo $resultCase['c_pid']; ?>">
                  <input name="reciID" type="hidden" value="<?php echo $resultCase['c_rid']; ?>">
                  <input name="caseID" type="hidden" value="<?php echo $caseID; ?>">
                  <label class="text-left" for="reportItem"><i class="fas fa-exclamation-circle"></i> 檢舉項目</label>
                  <select name="reportItem" class="form-control">
                    <option value="不雅的案件名稱或內容">不雅的案件名稱或內容</option>
                    <option value="態度惡劣">態度惡劣</option>
                    <option value="持續騷擾">持續騷擾</option>
                    <option value="未達成工作需求">未達成工作需求</option>
                    <option value="遲遲不肯按確認鍵">遲遲不肯按確認鍵</option>
                    <option value="Other">其他</option>
                  </select>
                  <textarea id="reportContent" name="reportContent" placeholder="輸入對此次案件的評價！">告訴我們這件案件發生什麼問題？</textarea>
                  <div class="text-right">
                    <button type="submit" id="submitRaty" class="caseDetailButton">
                      <i class="far fa-comment-dots"></i>
                      <span class="caseDetailButtonText">檢舉</span>
                    </button>
                  </div>
                </form>
              </div>
            <?php } ?>
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
                      <?php if ($resultQuestion['q_atext'] != NULL) { ?>
                        <div class="text-left">
                          <div class="caseQnADate"><?php echo $resultQuestion['q_updated_at']; ?></div>
                          <div style="clear: both;"></div>
                        </div>
                        <div class="caseQnAText">
                          <?php echo $resultQuestion['q_atext']; ?>
                        </div>
                      <?php } elseif (@$userID != NULL && $resultQuestion['q_aid'] == @$userID) { ?>
                        <div id="answerDiv<?php echo $resultQuestion['q_qid']; ?>" class="answerDiv text-right">
                          <form id="answerForm<?php echo $resultQuestion['q_qid']; ?>" name="answerForm" class="answerForm">
                            <textarea id="answer<?php echo $resultQuestion['q_qid']; ?>" name="answer" placeholder="回答他的問題吧！"></textarea>
                            <button data-qid="<?php echo $resultQuestion['q_qid']; ?>" type="button" class="caseDetailButton answerBtn">
                              <i class="far fa-comment-dots"></i>
                              <span class="caseDetailButtonText">送出</span>
                            </button>
                          </form>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>