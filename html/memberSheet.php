<?php
require("model.php");

$email = $_REQUEST['email'];
$groupId = $_REQUEST['groupId'];
$sheetId = getGroupSheet($groupId);
$role = checkRole($email,$groupId);
// setting
echo "<br/>";
list($name,$email,$phoneNumber,$position,$group) = settingGroup($groupId);
if($role > 90){  
  for($x = 1 ;$x < count($name) ; $x++){
    echo "<br/>";
    $realNo = $x+1;
    echo "row no:".$realNo."";
    echo $name[$x]."_".$email[$x]."_".$phoneNumber[$x]."_".$position[$x]."_".$group[$x];
    echo "<a href='control.php?act=deleteSheetData&sheetId=".$sheetId."&no=".$realNo."'>  CLEAR</a>";
  }
  echo '
    <form action = "control.php" method="post">
      Name: <input type="text" name="name">
      E-mail: <input type="text" name="email">
      tel:<input type="text" name="phoneNumber">
      position:<input type="text" name="position">
      group:<input type="text" name="group">
      <input type="hidden" name="sheetId" value='.$sheetId.'>
      <input type="submit" name="act" value="addData">
    </form>
  ';
}else{
	for($x = 1 ;$x < count($name) ; $x++){
    echo "<br/>";
    $realNo = $x+1;
    echo "row no:".$realNo."";
    echo $name[$x]."_".$email[$x]."_".$phoneNumber[$x]."_".$position[$x]."_".$group[$x];
  }
}
?>