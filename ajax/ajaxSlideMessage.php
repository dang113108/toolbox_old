<?php
foreach ($_SESSION as $key => $value) {
	$$key = $value;
}
?>