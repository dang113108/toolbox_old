<?php
session_start();
include("../mysqli_connect.inc.php");
include("../testArray.php");
if (@$_SESSION['userAccount'] == NULL) {
	header("Location: error.php");
	exit;
}
foreach ($_POST as $key => $value) {
	$$key = $value;
}
foreach ($addressArray[$c_town] as $value) { ?>
	<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
	<?php } ?>