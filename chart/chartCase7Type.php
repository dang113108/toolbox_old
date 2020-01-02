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
$selectCase = "SELECT * FROM `cases_copy` WHERE `c_time` BETWEEN NOW() - INTERVAL 7 DAY AND NOW()";
$queryCase = mysqli_query($link, $selectCase);
while ($resultCase = mysqli_fetch_array($queryCase)) {
	switch ($resultCase['c_category']) {
		case '日常':
		$count0++;
		break;
		case '外送':
		$count1++;
		break;
		case '修繕':
		$count2++;
		break;
		case '除蟲':
		$count3++;
		break;
		case '接送':
		$count4++;
		break;
		case '課業':
		$count5++;
		break;
	}
}
echo json_encode(array($count0, $count1, $count2, $count3, $count4, $count5));
?>