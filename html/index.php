<?php
require("model.php");
$_SESSION["status"] = checkLogin();
if ($_SESSION["status"] == "false") {
    // echo "Login First, please";
    // echo "<br />";
    // echo "jump to login page in 5 second";
    // sleep(5);
    // getClient();
  $name = "no login";
  echo "user : " . $name;
  echo "<br/>";
  echo "login First";
  echo '<form action="../html/control.php" method="post">
			<input type="submit" name="act" value="getClient"><br/>
		</form>
		';
} else {
  $name = getJoinedGroup();
  echo $name;
	// echo '<form action="https://accounts.google.com/Logout?hl=en" method="post"><input type="submit" name="act" value="account setting"><br/></form>';
  echo '
	<form action="control.php" method="post">
		<input type="submit" name="act" value="logout"><br/>
	</form>
	';
}
?>