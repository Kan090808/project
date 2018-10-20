<?php
require("model.php");
$_SESSION["status"] = checkLogin();
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
  echo $name;
  echo "<br/>";
  list($groupName,$groupId,$currentYear)= getJoinedGroup($email);
  echo "<br/>";

  for($i=0;$i<count($groupName);$i++){
    echo $groupName[$i].$currentYear[$i];
    // call this to get current year folder's id;
    $currentFolderId = getCurrentYearGroup($groupId[$i],$currentYear[$i]);
    echo "<a href='control.php?act=getFolderList&pId=".$currentFolderId."&type=1'>  Goto current year folder</a>";
    $sheetId = getGroupSheet($groupId[$i]);
    // sidebar, $groupId[$i]
<<<<<<< HEAD
    echo "<br />";
    $list = listFolderTree($groupId[$i]);
    for($j=0;$j<count($list);$j++){
      echo $list[$j][0];
      echo $list[$j][1];
      echo "<br/>";
      $listFolder = listFolderTree($list[$j][1]);
      for($k=0;$k<count($listFolder);$k++)
      {
        echo $listFolder[$k][0];
        echo $listFolder[$k][1];
        echo "<br />";
      }
      echo "<br />";
    }
=======
    // all year
    echo "<br/>-------------all year-------";
    listFolderTree($groupId[$i]);
>>>>>>> 4eeb84f922d971167a969380036479b086c2ede0
    // 檔案列出 用$groupId[$i] 達成
    list($fileName,$fileId,$fileType,$lastMod,$fileSize)=getFolderList($groupId[$i],2);
    
    // setting
    echo "<br/>"; 
    list($name,$email,$phoneNumber,$position,$group) = settingGroup($groupId[$i]);
    for($i = 1 ;$i < count($name) ; $i++){
      echo "<br/>";
      $realNo = $i+1;
      echo "row no:".$realNo."";
      echo $name[$i]."_".$email[$i]."_".$phoneNumber[$i]."_".$position[$i]."_".$group[$i];
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
    // appendData2($name, $email, $phone, $position, $year, $groupId[$i]);

    // 檔案資料列出
    echo "<br/>"; 
    for($i = 0 ;$i < count($fileName) ; $i++){
      echo "<br/>";
      echo $fileName[$i]."_".$fileId[$i]."_".$fileType[$i]."_".$fileSize[$i]."_".$lastMod[$i];
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