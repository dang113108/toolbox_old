<script src="https://www.gstatic.com/firebasejs/5.5.8/firebase.js"></script>
<link rel="manifest" href="/manifest.json">
<script src="js/firebaseInit.js"></script>
<?php
$user_admin = array("回首頁", "分析", "案件管理", "用戶管理", "登出");
$user_admin_url = array("/caseview.php" ,"/analytics.php" ,"/caseManage.php" ,"/userManage.php" ,"/logout.php");
$nowPage = getenv('REQUEST_URI');?>
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container">
    <a class="navbar-brand" href="index.php">ToolBox</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
        <?php if (@$_SESSION['level'] == '管理員') {
          foreach ($user_admin as $index => $value) {?>
            <li class="nav-item">
              <a class="btn" href="<?php echo $user_admin_url[$index]; ?>">
                <?php echo $value; ?>
              </a>
            </li>
          <?php } } else {
            header("Location: error.php");
            exit;
          } ?>
        </ul>
      </div>

    </div>
  </nav>