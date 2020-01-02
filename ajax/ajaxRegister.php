<?php
session_start();
include("../mysqli_connect.inc.php");
use PHPMailer\PHPMailer\PHPMailer;
require '../vendor/autoload.php';

if (@$_SESSION['userAccount'] != NULL) {
	header("Location: error.php");
	exit;
} else {
	foreach ($_POST as $key => $value) {
		$$key = $value;
	}
	$u_mail = $emailAddress . '@' . $emailServer;

	function imgur_upload($image, $title = '') {
		$url = 'https://imgur-apiv3.p.mashape.com/3/image/';
		$mashape_key = "XR6S0dZU7Hmsh289zCmGwLH8tQNrp1KA0jfjsn8EHvOt1q8QR5"; //填入自己的 Mashape Key
		$client_id = "6989dec20061743"; //填入自己的 Client ID

		//要用 http header 送出的參數
		$http_header_array = [
			"X-Mashape-Key: $mashape_key",
			"Authorization: Client-ID $client_id",
			"Content-Type: application/x-www-form-urlencoded",
		];

		//要用 post 送出的參數
		$curl_post_array = [
			'image' => $image,
			'title' => $title,
		];

		//將 http header 與 post 加進 curl 的 option
		$curl_options = [
			CURLOPT_HTTPHEADER => $http_header_array,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($curl_post_array),
		];
		$curl_info = null;
		$curl_result = use_curl_opt($url, $curl_options, $curl_info);

		return $curl_result;
	}

	function use_curl_opt($url, $options = [], &$curl_info = null) {
		$ch = curl_init();
		$default_options = [
			CURLOPT_URL => $url,
			CURLOPT_HEADER => 0,
			CURLOPT_VERBOSE => 0,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 5.1; rv:10.0.2) Gecko/20100101 Firefox/10.0.2",
		];
		curl_setopt_array($ch, $default_options);
		curl_setopt_array($ch, $options);
		$curl_result = curl_exec($ch);
		$curl_info = curl_getinfo($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);

		if ($curl_result) {return $curl_result;} else {return $curl_error;}
	}

	function sendMail($u_mail, $u_name, $u_verifyCode) {
		$mail = new PHPMailer;
		$mail->isSMTP();
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 0;
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true,
			),
		);
		$mail->Port = 587;
		$mail->SMTPSecure = 'tls';
		$mail->CharSet = "UTF8";
		$mail->SMTPAuth = true;
		$mail->Username = "ToT.Toolbox@gmail.com";
		$mail->Password = "onenightstandyo";
		$mail->setFrom('ToT.Toolbox@gmail.com', 'ToolBox 驗證工具人');
		$mail->addAddress($u_mail, $u_name);
		$mail->Subject = 'ToolBox 信箱驗證信';
		$mail->Body = '你好，驗證碼底加：' . $u_verifyCode . "\n或是你可以直接點擊連結：http://" . $_SERVER['HTTP_HOST'] . "/caseview.php?code=" . $u_verifyCode;
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
			return false;
		} else {
			return true;
		}
	}

	function getRand() {
		$u_verifyCode = rand(1, 9999);
		switch (strlen((string) $u_verifyCode)) {
			case 1:
			$u_verifyCode = '000' . $u_verifyCode;
			break;
			case 2:
			$u_verifyCode = '00' . $u_verifyCode;
			break;
			case 3:
			$u_verifyCode = '0' . $u_verifyCode;
			break;
		}
		if (strlen((string) $u_verifyCode) != 4) {
			getRand();
		} else {
			return $u_verifyCode;
		}
	}

	$select = "SELECT 'u_uid' FROM `users` WHERE `u_mail` = '$u_mail'";
	$result_s = mysqli_query($link, $select);
	$output_duplicate = mysqli_fetch_array($result_s);
	if ($output_duplicate[0] == "") {
		if (isset($_FILES['userImage'])) {
			$file = $_FILES['userImage'];
			if ($file['name'] == '') {die('image error');
		}

			//讀取上傳的檔案並轉為 base64 字串
		$filepath = $file['tmp_name'];
		$handle = @fopen($filepath, "r");
		$data = @fread($handle, filesize($filepath));
		$image_base64 = base64_encode($data);

			//呼叫前面寫的 function imgur_upload
		$imgur_result = imgur_upload($image_base64, $file['name']);
		$imgur_result = json_decode($imgur_result);

		foreach ($imgur_result as $key => $value) {
			if (@"$value->id" != "") {
					//how to use json array to insert da@ta in Database
				$u_image = @"$value->id";
				break;
			}
		}
	}
	$u_verifyCode = getRand();
	$u_verify = '未驗證';
	$u_black = 0;
	$insert_user = "INSERT INTO `users` (`u_uid`, `u_mail`, `u_pwd`, `u_identity`, `u_image`, `u_name`, `u_nickname`, `u_phone`, `u_sex`, `u_address`, `u_verify`, `u_verifyCode`, `u_regtime`, `u_black`, `u_introduce`, `update_time`) VALUES (NULL, '$u_mail', '$password', '$userIdentity', '$u_image', '$userName', '$userNickname', '$userCellphone', '$userSex', '$userAddress', '$u_verify', '$u_verifyCode', CURRENT_TIMESTAMP, '$u_black', '$userIntroduce', CURRENT_TIMESTAMP)";
	if ($result = mysqli_query($link, $insert_user)) {
		if (sendMail($u_mail, $userName, $u_verifyCode)) {
			$last_id = mysqli_insert_id($link);
			$_SESSION['userID'] = $last_id;
			$_SESSION['userAccount'] = $u_mail;
			$_SESSION['userName'] = $userName;
			$_SESSION['userNickName'] = $userNickname;
			$_SESSION['userImg'] = "https://imgur.com/" . $u_image . ".jpg";
			$_SESSION['verify'] = '未驗證';
			$_SESSION['level'] = '一般使用者';
			echo "register success";
		} else {
			echo "Mail Send Error, please notify managers or try again.";
		}
	} else {
		echo "Insert Error, please notify managers or try again.";
	}
} else {
	echo "This account has already been registered";
}
}
?>