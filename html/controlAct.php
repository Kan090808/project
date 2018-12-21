<?php
require("model.php");
echo "活動幹部名單-現有";
$activityName = $_REQUEST['activityName'];
$belong = $_REQUEST['belong'];
$belongYear = $_REQUEST['belongYear'];
$actCrewSheet = getActivityCrewMember($activityName,$belong,$belongYear);
$actId = getActIdBySheet($actCrewSheet);
list($name,$email,$phoneNumeber,$position) = readCrewSheet($actCrewSheet);
for($i = 0; $i < count($name); $i++){
	echo "<br>".$name[$i]."__".$email[$i]."__".$phoneNumeber[$i]."__".$position[$i];
}
if(checkRole(getEmail(),$belong) > 90){
	echo "<br>";
	echo "
		<form action='control.php' method='post'>
			name
			<input type='text' name='name' value=''>
			email
			<input type='text' name='email' value=''>
			phone
			<input type='text' name='phone' value=''>
			position
			<input type='text' name='position' value=''>
			<input type='hidden' name='actCrewSheetId' value='".$actCrewSheet."'>
			<input type='submit' name='act' value='appendDataToCrewMemberSheet'>
		</form>
	";
	echo "從會員sheet抓過來";
	$rt = printMemberSheetValue(getGroupMemberSheet($belong),checkRole(getEmail(),$belong));
	list($name,$id,$gender,$class,$department,$year,$gmail,$tel,$diet,$skill,$prefer,$status) = $rt;
	for($x = 0 ;$x < count($name) ; $x++){
    	echo "<br/>";
    	$realNo = $x+1;
    	echo "row no:".$realNo."";
    	// echo $name[$x]."_".$id[$x]."_".$class[$x]."_".$department[$x]."_".$year[$x];
    	echo "
    	<form action = 'control.php' method= 'post'>
    		name
    		<input type='text' name='name' value='".$name[$x]."' readonly>
    		email
    		<input type='text' name='email' value='".$gmail[$x]."' readonly>
    		phone
    		<input type='text' name='phone' value='".$tel[$x]."' readonly>
    		position
    		<input type='text' name='position' value=''>
    		<input type='hidden' name='actCrewSheet' value='".$actCrewSheet."'>
    		<input type='submit' name='act' value='copyMemberToCrew'>
    	</form>";
    	
  }
}
// feature
// - add member
// -  
?>