<script src="https://www.gstatic.com/firebasejs/5.5.8/firebase.js"></script>
<script src="../js/jquery.raty.js"></script>
<link rel="manifest" href="/manifest.json">
<link href="css/toast.css" rel="stylesheet" type="text/css">
<?php
$user_null = array("註冊", "登入");
$user_null_url = array("/register.php", "/login.php");
$user_verify = array("會員中心","登出");
$user_verify_url = array("/memberCenter.php","/logout.php");
$user_admin = array("後台管理","會員中心","登出");
$user_admin_url = array("/analytics.php","/memberCenter.php","/logout.php");
$user_else = array("會員中心","登出");
$user_else_url = array("/memberCenter.php","/logout.php");
$nowHost = $_SERVER['HTTP_HOST'];
$nowPage = getenv('REQUEST_URI');
if (@$userID != "") {
  include "slideTab.php";
}
?>
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">ToolBox</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <form name="navForm" id="navForm" class="form-inline" method="GET" action="caseview.php">
      <div class="input-group input-group-sm">
        <div class="input-group-prepend">
          <select name="type" class="form-control form-control-sm btn btn-outline-secondary dropdown-toggle searchBtn">
            <option value="全部">全部</option>
            <option value="日常">日常</option>
            <option value="外送">外送</option>
            <option value="修繕">修繕</option>
            <option value="除蟲">除蟲</option>
            <option value="接送">接送</option>
            <option value="課業">課業</option>
            <option value="其他">其他</option>
          </select>
        </div>
        <input name="keyword" type="text" class="form-control" placeholder="搜尋…" aria-label="Recipient's username" aria-describedby="basic-addon2" value="<?php echo @$keyword; ?>">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary searchBtn" type="submit">搜尋</button>
        </div>
      </div>
    </form>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <li class="nav-item">
          <a class="btn" href="caseview.php">
            開始使用
          </a>
        </li>
        <?php if (@$_SESSION['userID'] == null) {
          foreach ($user_null as $index => $value) {?>
            <li class="nav-item">
              <a class="btn" href="<?php echo $user_null_url[$index]; ?>">
                <?php echo $value; ?>
              </a>
            </li>
          <?php }
        } else { ?>
          <!-- 測試通知 -->
          <script type="text/javascript">
            $(function () {
              $('[data-toggle="popover"]').popover();
              $('[data-toggle="tooltip"]').tooltip();

              function selectDollar (dollar) {
                $.ajax({
                  type: 'post',
                  async: false,
                  url: './ajax/ajaxDollarLongPolling.php',
                  data: {
                    dollar : dollar
                  },
                  success: function (data) {
                    if (dollar != data) {
                      $("#userDollar").text(data);
                    }
                    // selectDollar(data);
                  },
                  error: function() {
                    // selectDollar(dollar);
                  },
                  timeout: 300000
                });
              }
              selectDollar(0);
            });
            function callLINEAPI() {
              var x = document.getElementById("snackbar");
              x.className = x.className.replace("show", "");
              var highestTimeoutId = setTimeout(";");
              for (var k = 0 ; k < highestTimeoutId ; k++) {
                clearTimeout(k);
              }
              x.innerHTML = "儲值中";
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
              var money = $("#lineMoney").val();
              var userMail = '<?php echo @$_SESSION['userAccount']; ?>';
              var data = {
                "money" : money,
                "account" : userMail
              }
              $.ajax({
                type: 'post',
                url: 'https://a238c12f.ngrok.io/reserve_weblinebot_API',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function (data) {
                 var x = document.getElementById("snackbar");
                 x.className = x.className.replace("show", "");
                 var highestTimeoutId = setTimeout(";");
                 for (var k = 0 ; k < highestTimeoutId ; k++) {
                  clearTimeout(k);
                }
                x.innerHTML = data;
                x.className = "show";
                setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
              },
              error: function (jqXHR, textStatus, errorThrown) {
               var x = document.getElementById("snackbar");
               x.className = x.className.replace("show", "");
               var highestTimeoutId = setTimeout(";");
               for (var k = 0 ; k < highestTimeoutId ; k++) {
                clearTimeout(k);
              }
              x.innerHTML = jqXHR.responseText;
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
          });
              $('[data-toggle="popover"]').popover('hide');
            }
          </script>
          <li class="nav-item">
            <a class="btn" data-container="body" data-toggle="popover" data-placement="bottom" data-html="true" title="LINE Pay儲值" data-content="<div><input id='lineMoney' type='number'></input><button class='btn btn-primary sumbitLine' onclick='callLINEAPI();'>儲值</button></div><div>需於手機板LINE上確認。</div>">
              <i class="fas fa-dollar-sign"></i> <span id="userDollar" class="badge badge-light">0</span>
            </a>
          </li>
          <!-- 測試通知 -->
          <?php if (@$_SESSION['verify'] == '未驗證') { ?>
            <script src="js/verifyCode.js"></script>
            <li class="btn">
              <a class="nav-link" href="" data-toggle="modal" data-target="#verifyModal">
                驗證信箱
              </a>
            </li>
            <?php foreach ($user_verify as $index => $value) {?>
              <li class="nav-item">
                <a class="btn" href="<?php echo $user_verify_url[$index]; ?>">
                  <?php echo $value; ?>
                </a>
              </li>
            <?php } } elseif (@$_SESSION['level'] == '管理員') {
              foreach ($user_admin as $index => $value) {?>
                <li class="nav-item">
                  <a class="btn" href="<?php echo $user_admin_url[$index]; ?>">
                    <?php echo $value; ?>
                  </a>
                </li>
              <?php } } else { ?>
                <?php foreach ($user_else as $index => $value) {?>
                  <li class="nav-item">
                    <a class="btn" href="<?php echo $user_else_url[$index]; ?>">
                      <span><?php echo $value; ?></span>
                    </a>
                  </li>
                <?php } } }?>
              </ul>
            </div>

          </div>
        </nav>
        <!-- 吐司 -->
        <div id="snackbar"></div>
        <?php if (@$_SESSION['verify'] == '未驗證') { ?>
          <!-- Modal -->
          <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">輸入信箱驗證碼</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form id="verifyForm" method="GET">
                  <div class="modal-body">
                    <label>請輸入驗證碼：<input type="text" id="verifyCode" name="verifyCode" value=""></label>
                    <p>沒有收到? <a href="caseview.php">點我重發</a></p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    <button type="submit" class="btn btn-primary">驗證</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- 吐司 -->
          <div id="snackbar"></div>
          <?php } ?>