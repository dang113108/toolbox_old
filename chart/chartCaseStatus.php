<?php
session_start();
include("../mysqli_connect.inc.php");
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
$count0 = 0;
$count1 = 0;
$count2 = 0;
$count3 = 0;
$count4 = 0;
$count5 = 0;
$selectCase = "SELECT * FROM `cases_copy`";
$queryCase = mysqli_query($link, $selectCase);
while ($resultCase = mysqli_fetch_array($queryCase)) {
	switch ($resultCase['c_status']) {
		case '待接案':
		$count0++;
		break;
		case '進行中':
		$count1++;
		break;
		case '確認中':
		$count2++;
		break;
		case '已完成':
		$count3++;
		break;
		case '已過期':
		$count4++;
		break;
		case '爭議中':
		$count5++;
		break;
	}
}
echo json_encode(array($count0, $count1, $count2, $count3, $count4, $count5));
?>