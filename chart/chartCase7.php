<?php
session_start();
date_default_timezone_set("Asia/Taipei");
include("../mysqli_connect.inc.php");
foreach (@$_SESSION as $key => $value) {
	$$key = $value;
}
$countType = array(array());
$dateArray = array();
for ($i=0; $i < 2; $i++) {
	for ($j=0; $j < 7; $j++) {
		$countType[$i][$j] = 0;
	}
}
for ($i = 0; $i < 7; $i++) {
	$dateArray[$i] = date('m-d', strtotime('-' . (6-$i) .' days'));
}
array_push($countType, $dateArray);
$selectCase = "SELECT * FROM `cases_copy` WHERE `c_time` BETWEEN NOW() - INTERVAL 7 DAY AND NOW()";
$queryCase = mysqli_query($link, $selectCase);
while ($resultCase = mysqli_fetch_array($queryCase)) {
	foreach ($countType[2] as $key => $value) {
		if ($value ==  substr($resultCase['c_time'], 5, 5)) {
			if ($resultCase['c_status'] != "待接案") {
				$countType[1][$key]++;
			}
			$countType[0][$key]++;
		}
	}

}
echo json_encode($countType);
?>