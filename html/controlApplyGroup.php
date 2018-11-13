<?php
require("model.php");
list($email,$name,$status) = getApplyGroup();
for($i=0;$i<count($name);$i++){
	echo $email[$i]."__".$name[$i];
	if($status[$i] == 0){
		echo "
			<form action='control.php' method=post>
				<input type=hidden name=groupName value='$name[$i]'>
				<input type=hidden name=email value='$email[$i]'>
				<input type=submit name=act value=approveApply>
			</form>
		";
		echo "
			<form action='control.php' method=post>
				<input type=hidden name=groupName value='$name[$i]'>
				<input type=hidden name=email value='$email[$i]'>
				<input type=submit name=act value=refuseApply>
			</form>
		";
	}else if($status[$i] == 1){
		echo "[APPROVED]";
	}
	echo "<br>";
}
?>