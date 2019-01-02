<?php
require("model.php");
$_SESSION["status"] = checkLogin();
$email = getEmail();
echo '
	<form action="control.php" method=post>
		<input type=text name=newGroupName value="">
		<input type=text name=email value="'.$email.'" readonly>
		<input type=submit name=act value=newApplyGroup>
	</form>
';
?>