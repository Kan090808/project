<?php
require("model.php");

$email = $_REQUEST['email'];
$groupId = $_REQUEST['groupId'];
$sheetId = getGroupMemberSheet($groupId);
$role = checkRole($email,$groupId);
// setting
echo "this test page is for view or edit memberSheet of a group<br/>";

list($name,$email,$phoneNumber,$position,$group) = settingGroup($groupId);
if($role >= 90){  
  $rt = printMemberSheetValue($sheetId,$role);
  list($name,$gender,$class,$year,$gmail,$tel,$diet,$skill,$prefer,$status) = $rt;
  for ($i=0;$i<count($name);$i++){
    echo "<br/>".$i."_".$name[$i]."_".$gender[$i];
    if($status[$i]==0){
      echo "__waiting to approved";
      echo '
        <form action = "control.php" method="post">
          <input type="hidden" name="no" value="'.$i.'">
          <input type="hidden" name="sheetId" value="'.$sheetId.'">
          <input type="submit" name="act" value="approvedMember">
        </form>
      ';
    }else if($status == 1){
      echo "__member";
      echo '
        <form action = "control.php" method="post">
          <input type="hidden" name="no" value="'.$i.'">
          <input type="hidden" name="sheetId" value="'.$sheetId.'">
          <input type="submit" name="act" value="removeMember">
        </form>
      ';
    }
  }
}else{
	for($x = 1 ;$x < count($name) ; $x++){
    echo "<br/>";
    $realNo = $x+1;
    echo "row no:".$realNo."";
    echo $name[$x]."_".$email[$x]."_".$phoneNumber[$x]."_".$position[$x]."_".$group[$x];
  }
}
?>