<?php
require('model.php');
$string =$_REQUEST['value'];
$email = getEmail();
$sql = "select * from `member`.`group` where groupName like '%".$string."%' ";
$rt = getDb($sql,4);
while ($row=mysqli_fetch_row($rt)){
	$status = checkIfJoinedThisGroup($row[2],$email);
	$groupId = $row[2];
	echo $row[1]."---".$row[4];
	if($status == null){
		echo "
		    <form method='post' action='insertMember.php'>
		      <input type='hidden' name='act' value='newMemberDetail'>
		      <input type='hidden' name='email' value='".$email."'>
		      <input type='hidden' name='groupId' value='".$groupId."'>
		      <input type='submit' value = 'Apply to join this Group'>
		    </form>";
	}else if($status == 0){
		echo "<br/>";
		echo "applying... wait for approve or reject";
	}else if($status == 1){
		echo "<br/>";
		echo "joined";
	}
}
?>