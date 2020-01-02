<?php
$db_name ="toolbox";
$mysql_username="testing";
$mysql_password="@Toolbox87";
$server_name="127.0.0.1";
$link =mysqli_connect($server_name, $mysql_username, $mysql_password, $db_name);
mysqli_query($link,'SET NAMES utf8');
if ($link){

} else {
	echo mysqli_connect_error();
}