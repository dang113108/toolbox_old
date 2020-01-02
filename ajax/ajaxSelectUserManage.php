<?php
include("../mysqli_connect.inc.php");
foreach ($_POST as $key => $value) {
	$$key = $value;
}
$selectUser = "SELECT * FROM `users` WHERE `u_uid` = '$userUID'";
$queryUser = mysqli_query($link, $selectUser);
$resultUser = mysqli_fetch_array($queryUser);
$email = explode('@', $resultUser['u_mail']);
?>
<form class="userForm" name="userForm" id="userForm" method="POST">
	<input type="hidden" name="userID" value="<?php echo $userUID; ?>">
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="emailAddress">Email 帳號</label>
			<input type="text" class="form-control" id="emailAddress" name="emailAddress" placeholder="輸入您的學號" pattern="[A-Za-z0-9]+" minlength="2" maxlength="40" value="<?php echo $email[0]; ?>" required>
		</div>
		<div class="form-group col-md-6">
			<label for="emailServer">Email 伺服器</label>
			<select id="emailServer" name="emailServer" class="form-control">
				<option value="gm.cyut.edu.tw" <?php if ($email[1] == "gm.cyut.edu.tw") { echo "selected"; } ?>>@gm.cyut.edu.tw</option>
				<option value="cyut.edu.tw" <?php if ($email[1] == "cyut.edu.tw") { echo "selected"; } ?>>@cyut.edu.tw</option>
			</select>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="password">密碼</label>
			<input type="password" class="form-control" id="password" name="password" placeholder="輸入您的密碼" minlength="6" maxlength="12" value="<?php echo $resultUser['u_pwd']; ?>" required>
		</div>
		<div class="form-group col-md-6">
			<label for="userCellphone">手機</label>
			<input type="text" class="form-control" id="userCellphone" name="userCellphone" placeholder="輸入您的手機號碼" pattern="[0-9]+" minlength="10" maxlength="10" value="<?php echo $resultUser['u_phone']; ?>" required>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="userName">姓名</label>
			<input type="text" class="form-control" id="userName" name="userName" placeholder="輸入您的姓名" minlength="2" maxlength="10" value="<?php echo $resultUser['u_name']; ?>" required>
		</div>
		<div class="form-group col-md-6">
			<label for="userNickname">暱稱</label>
			<input type="text" class="form-control" id="userNickname" name="userNickname" placeholder="輸入您的暱稱" minlength="2" maxlength="10" value="<?php echo $resultUser['u_nickname']; ?>" required>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="userIdentity">身分證字號</label>
			<input type="text" class="form-control" id="userIdentity" name="userIdentity" placeholder="輸入您的身分證字號" pattern="[A-Za-z0-9]+" minlength="10" maxlength="10" onblur="pidtest()" value="<?php echo $resultUser['u_identity']; ?>"required>
		</div>
		<div class="form-group col-md-6">
			<label for="userSex">性別</label>
			<input type="text" class="form-control" id="userSex" name="userSex" value="<?php echo $resultUser['u_sex']; ?>" readonly required>
		</div>
	</div>
	<div class="form-row">
		<div class="col">
			<div class="form-group">
				<label for="userAddress">住址</label>
				<input type="text" class="form-control" id="userAddress" name="userAddress" placeholder="輸入您的現居地址" minlength="2" maxlength="50" value="<?php echo $resultUser['u_address']; ?>" required>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="col">
			<div class="form-group">
				<label for="userIntroduce">自我介紹</label>
				<textarea class="form-control" id="userIntroduce" name="userIntroduce" rows="3" minlength="10" maxlength="500" required><?php echo $resultUser['u_introduce']; ?></textarea>
			</div>
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-md-6">
			<label for="userLevel">權限</label>
			<select id="userLevel" name="userLevel" class="form-control">
				<option value="一般使用者" <?php if ($resultUser['u_level'] == "一般使用者") { echo "selected"; } ?>>一般使用者</option>
				<option value="管理員" <?php if ($resultUser['u_level'] == "管理員") { echo "selected"; } ?>>管理員</option>
			</select>
		</div>
		<div class="form-group col-md-6">
			<label for="userEnable">啟用</label>
			<select id="userEnable" name="userEnable" class="form-control">
				<option value="0" <?php if ($resultUser['u_black'] == "0") { echo "selected"; } ?>>啟用</option>
				<option value="1" <?php if ($resultUser['u_black'] == "1") { echo "selected"; } ?>>禁用</option>
			</select>
		</div>
	</div>
	<div class="form_row">
		<button type="submit" class="btn btn-primary form-control themeBGColor">更新</button>
	</div>
</form>
<script src="../js/userManageUpdate.js"></script>