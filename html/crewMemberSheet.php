<?php
require("model.php");

$email = $_REQUEST['email'];
$groupId = $_REQUEST['groupId'];
$sheetId = getGroupMemberSheet($groupId);
$role = checkRole($email,$groupId);
// setting
// test();
echo "this test page is for view or edit crewMemberSheet of a group<br/>";
echo "you role number is ".$role;
list($name,$email,$phoneNumber,$position,$group) = settingGroup($groupId);
if($role >= 90){
	for($x=0;$x<count($name);$x++){
		echo "<br>";
		$realNo = $x+1;
	    echo "row no:".$realNo."";
	 	echo $name[$x]."_".$email[$x]."_".$phoneNumber[$x]."_".$position[$x]."_".$group[$x];
	}
}else{
	for($x=0;$x<count($name);$x++){
		echo "<br>";
		$realNo = $x+1;
	    echo "row no:".$realNo."";
	 	echo $name[$x]."_".$email[$x]."_".$phoneNumber[$x]."_".$position[$x]."_".$group[$x];
	}
}
?>