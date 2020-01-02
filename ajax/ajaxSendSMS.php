 <?php
 foreach ($_POST as $key => $value) {
 	$$key = $value;
 }
 sms($message,$phoneNumber);

function sms($c,$p){//$c：簡訊內容 $p：手機號碼
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://api.message.net.tw/send.php?id=0919038457&password=a8735457&tel='.$p.'&msg='.urlencode($c).'&mtype=G&encoding=utf8');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_exec($ch);
	curl_close($ch);
	echo $c . " " . $p;
}
?>