<?php
require("model.php");
$_SESSION["status"] = checkLogin();
echo "Search Group";
echo '
  <form action = "control.php" method="post">
    <input type="hidden" name="pId" value="$currentFolderId.">
    <input type="text" name="searchContent" value="">
    <input type="submit" name="act" value="searchGroup">
  </form>
';
if ($_SESSION["status"] == "false") {
  $name = "no login";
  echo "user : " . $name;
  echo "<br/>";
  echo "login First";
  echo '<form action="../html/control.php" method="post">
			<input type="submit" name="act" value="getClient"><br/>
		</form>
		';
} else {
  $email = getEmail();
  echo $email;
  echo "<br/>";
	$name = getName();
  $role = getRole($email);
  echo $name;
  echo "<br/>";
  list($groupName,$groupId,$currentYear) = getJoinedGroup($email);
  echo "<br/>";

  for($i=0;$i<count($groupName);$i++){
    echo "<br/>";
    echo $groupName[$i].$currentYear[$i];
    // call this to get current year folder's id;
    $currentFolderId = getCurrentYearGroup($groupId[$i],$currentYear[$i]);
    echo '
      <form action = "control.php" method="post">
        <input type="hidden" name="pId" value="$currentFolderId.">
        <input type="hidden" name="type" value="2">
        <input type="submit" name="act" value="getFolderList">
      </form>
    ';
    // 帶1進去，從model裡面echo出來
    // 帶2進去，回傳array
    getFolderList($currentFolderId,1);
    $sheetId = getGroupSheet($groupId[$i]);
    // sidebar, $groupId[$i]
    // all year
    echo "<br/>-------------all year-------";
    listFolderTree($groupId[$i]);
    // 檔案列出 用$groupId[$i] 達成
    list($fileName,$fileId,$fileType,$lastMod,$fileSize)=getFolderList($groupId[$i],2);
    
    // setting
    echo "<br/>"; 
    if($role == 99){
      list($name,$email,$phoneNumber,$position,$group) = settingGroup($groupId[$i]);
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
    }

    // 檔案資料列出
    echo "<br/>"; 
    echo "aoe";
    for($x = 0 ;$x < count($fileName) ; $x++){
      echo "<br/>";
      echo $fileName[$x]."_".$fileId[$x]."_".$fileType[$x]."_".$fileSize[$x]."_".$lastMod[$x];
    }
  }

  if(isset($_SESSION['notCrew'])){
    echo "<br/>";
    echo "YOU ARE NOT CREW";
  }else{
    echo "<br/>";
    echo "YOU ARE CREW";
  }
  
  echo '
	<form action="control.php" method="post">
		<input type="submit" name="act" value="logout"><br/>
	</form>
	';
}
?>