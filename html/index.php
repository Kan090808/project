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
  $email = getEmail();
  echo $email;
  echo "<br/>";
	$name = getName();
  echo $name;
  echo "<br/>";
  list($groupName,$groupId)= getJoinedGroup($email);
  echo "<br/>";

  for($i=0;$i<count($groupName);$i++){
    echo $groupName[$i];
    echo '<a href = "control.php?act=settingGroup&gId='.$groupId[$i].'">setting this group</a>';
    // sidebar, $groupId[$i]
    listFolderTree($groupId[$i]);
    // 檔案列出 用$groupId[$i] 達成
    list($fileName,$fileId,$fileType,$lastMod,$fileSize)=getFolderList($groupId[$i],2);
  }

  if(isset($_SESSION['notCrew'])){
    echo "<br/>";
    echo "YOU ARE NOT CREW";
  }else{
    echo "<br/>";
    echo "YOU ARE CREW";
  }
  
  for($i = 0 ;$i < count($fileName) ; $i++){
    echo "<br/>";
    echo $fileName[$i]."_".$fileId[$i]."_".$fileType[$i]."_".$fileSize[$i]."_".$lastMod[$i];
  }
  echo '
	<form action="control.php" method="post">
		<input type="submit" name="act" value="logout"><br/>
	</form>
	';
}
?>