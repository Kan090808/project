<?php
require("model.php");
$_SESSION["status"] = checkLogin();
echo '
	<form action="control.php" method=post>
		<input type=text name=newGroupName value="">
		<input type=submit name=act value=newGroup>
	</form>
';
echo getEmail();
$rt = getJoinedGroup(getEmail());
var_dump($rt);
?>