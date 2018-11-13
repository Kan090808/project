<?php
require("model.php");

$email = $_REQUEST['email'];
$groupId = $_REQUEST['groupId'];
$sheetId = getGroupMemberSheet($groupId);
$crewSheet = getGroupCrewSheet($groupId);
$role = checkRole($email,$groupId);
$currenYear = getCurrentYear($groupId);
// setting
// test();
echo "this test page is for view or edit memberSheet of a group<br/>";
echo "you role number is ".$role;
$rt = printMemberSheetValue($sheetId,$role);
// var_dump($rt);
list($name,$id,$gender,$class,$department,$year,$gmail,$tel,$diet,$skill,$prefer,$status) = $rt;
if($role >= 90){
  for ($i=0;$i<count($name);$i++){
    echo "<br/>".$i."_".$name[$i]."_".$class[$i];
    if($status[$i]==0){
      echo "__waiting to approved";
      echo '
        <form action = "control.php" method="post">
          <input type="hidden" name="no" value="'.$i.'">
          <input type="hidden" name="sheetId" value="'.$sheetId.'">
          <input type="submit" name="act" value="approvedMember">
        </form>
      ';
    }else if($status[$i] == 1){
      echo "__member";
      echo '
        <form action = "control.php" method="post">
          <input type="hidden" name="no" value="'.$i.'">
          <input type="hidden" name="sheetId" value="'.$sheetId.'">
          <input type="submit" name="act" value="removeMember">
        </form>
      ';
      echo '
        <form action = "control.php" method="post">
          <input type="hidden" name="name" value="'.$name[$i].'">
          <input type="hidden" name="email" value="'.$gmail[$i].'">
          <input type="hidden" name="phone" value="'.$tel[$i].'">
          <input type="hidden" name="currentYear" value="'.$currenYear.'">
          position
          <input type="text" name="position" value="">
          role
          <input type="text" name="role" value="">
          <input type="hidden" name="crewSheet" value="'.$crewSheet.'">
          <input type="submit" name="act" value="copyMemberToCrew">
        </form>
      ';
    }
  }
}else{
	for($x = 0 ;$x < count($name) ; $x++){
    	echo "<br/>";
    	$realNo = $x+1;
    	echo "row no:".$realNo."";
    	echo $name[$x]."_".$id[$x]."_".$class[$x]."_".$department[$x]."_".$year[$x];
  }
}
?>