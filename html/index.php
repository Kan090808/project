<?php
require("model.php");
$_SESSION["status"] = checkLogin();
echo "Search Group";
echo '
  <form action = "control.php" method="post">
    <input type="hidden" name="pId" value="$currentFolderId">
    <input type="text" name="searchContent" value="">
    <input type="submit" name="act" value="searchGroup">
  </form>
';
echo '
  <form action = "control.php" method="post">
    <input type="submit" name="act" value="allGroup">
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
  // test();

  $initEmail = getEmail();
  echo $initEmail;
  echo "<br/>";
	$name = getName();
  echo $name;
  echo "<br/>";
  list($groupName,$groupId,$currentYear) = getJoinedGroup($initEmail);
  echo "<br/>";

  for($i=0;$i<count($groupName);$i++){
    $role = checkRole($initEmail,$groupId[$i]); 
    echo "<br/>";
    echo $groupName[$i].$currentYear[$i];
    $ifSetCrew = checkIfCrewMemberInit($groupId[$i]);
    if($ifSetCrew == "false"){
      echo "
        <form method='post' action='control.php'>
          <input type='hidden' name='groupId' value='$groupId[$i]'>
          <input type='submit' name=act value = 'initCrew'>
        </form>";
    }
    echo "
      <form method='post' action='crewMemberSheet.php'>
        <input type='hidden' name='email' value='$initEmail'>
        <input type='hidden' name='groupId' value='$groupId[$i]'>
        <input type='submit' value = 'crewMemberSheet'>
      </form>";
    echo "
      <form method='post' action='memberSheet.php'>
        <input type='hidden' name='email' value='$initEmail'>
        <input type='hidden' name='groupId' value='$groupId[$i]'>
        <input type='submit' value = 'memberSheet'>
      </form>";
      // call this to get current year folder's id;
    $currentFolderId = getCurrentYearGroup($groupId[$i],$currentYear[$i]);
    echo '
      <form action = "control.php" method="post">
        <input type="hidden" name="pId" value="$currentFolderId">
        <input type="hidden" name="type" value="2">
        <input type="submit" name="act" value="getFolderList">
      </form>';
      // 帶1進去，從model裡面echo出來
      // 帶2進去，回傳array
    // getFolderList($currentFolderId,1);
      // sidebar, $groupId[$i]
      // all year
    // echo "<br/>-------------all year-------";
    // listFolderTree($groupId[$i]);
    // // 檔案列出 用$groupId[$i] 達成
    // list($fileName,$fileId,$fileType,$lastMod,$fileSize)=getFolderList($groupId[$i],2);
    // for($x = 0 ;$x < count($fileName) ; $x++){
    //   echo "<br/>";
    //   echo $fileName[$x]."_".$fileId[$x]."_".$fileType[$x]."_".$fileSize[$x]."_".$lastMod[$x];
    // }
    $title = "";
    $attach = "";
    if(isset($_SESSION['tempTitle'])){
      $title = $_SESSION['tempTitle'];
    }
    echo "<br/>-------------post-------";
    $attach = "";
    $newPostAttach = "";
    if(isset($_SESSION['attach'])){
      $attach = base64_encode(serialize($_SESSION['attach']));
      // $attach = $_SESSION['attach'];
    }
    if(isset($_SESSION['newPostAttach'])){
      $newPostAttach = base64_encode(serialize($_SESSION['newPostAttach']));
      // $newPostAttach = $_SESSION['newPostAttach'];
    }
    echo '
      <form action = "control.php" method="post">
        po 文標題
        <input type="text" name="title" value="'.$title.'"><br/>
        新開文件
        <input type="text" name="title2" value="">
        <input type="hidden" name="belong" value="'.$groupId[$i].'">
        <input type="hidden" name="type" value="2">
        <input type="hidden" name="mime" value="doc">
        <input type="radio" name="newFileMime" value="doc"> doc
        <input type="radio" name="newFileMime" value="sheet"> sheet
        <input type="radio" name="newFileMime" value="slide"> slide
        <br>
        <input type="submit" name="act" value="newPostAttach">
        <input type="hidden" name="belong" value="'.$groupId[$i].'">
        <input type="submit" name="act" value="choseExistsToPost">
        <input type="hidden" name="attach" value="'.$attach.'">
        <input type="hidden" name="newPostAttach" value="'.$newPostAttach.'">
        <input type="hidden" name="postBy" value="'.$initEmail.'">
        <input type="submit" name="act" value="newPost">
      </form>
      ';
    echo '
      <form action = "control.php" method="post">
        <input type="submit" name="act" value="clearChoseSession">
      </form>';
      // var_dump($_SESSION['attach']);
      // echo '<pre>' . var_export($_SESSION['attach'], true) . '</pre>';
    if(isset($_SESSION['newPostAttach'])){
      echo "<br/>要新開的文件";
      $temp = $_SESSION['newPostAttach'];
      for($x=0;$x<count($temp);$x++){
        list($newPostAttachTitle,$newPostAttachBelong,$newPostType,$newPostAttachMime)=$temp[$x];
        // echo '<pre>' . var_export($temp[$x], true) . '</pre>';
        echo "<br/>".$newPostAttachTitle."_".$newPostAttachBelong."_".$newPostType."_".$newPostAttachMime;
      }
    }else{
      echo "<br/>沒有要新開的文件";
    }

    if(isset($_SESSION['attach'])){
      echo "<br/>掛載的文件";
      $temp = $_SESSION['attach'];
      for($x=0;$x<count($temp);$x++){
        list($title,$fileId,$belong,$posttype)=$temp[$x];
        // echo '<pre>' . var_export($temp[$x], true) . '</pre>';
        echo "<br/>".$title."_".$fileId."_".$belong."_".$posttype;
      }
    }else{
      echo "<br/>沒有掛載的文件";
    }
    echo "<br> show post-------------------";
    list($postId,$postTitle,$postAttach,$isMainAttach,$postBy)=getPost($groupId[$i],2);
    for($x=0;$x<count($postId);$x++){
      if($isMainAttach[$x] == true){
        // var_dump($postAttach);
        echo "<br/>".$postTitle[$x];
        echo "<br>PostBy :". $postBy[$x];
        $link = getFileLink($postAttach[$x]);
        $emblink = getEmb($postAttach[$x]);
        echo "<a href='$link'>view/edit in docs</a><br/>";
        echo "<iframe src = '$emblink'></iframe>";
      }else{
        echo "<br/>帖文附件：".$postTitle[$x]."___".$postAttach[$x];
      } 
    }
    echo "<br/>";
    echo '
      <form action = "control.php" method="post">
        <br>refresh drive folder permission by crewSheet
        <input type="hidden" name="groupId" value="'.$groupId[$i].'">
        <input type="submit" name="act" value="refreshGroupPermission">
      </form>'; 
    echo "<br/>";
    if($role >90){
      echo '
        <form action = "control.php" method="post">
          <input type="text" name="activityName" value="">
          <input type="hidden" name="belong" value="'.$groupId[$i].'">
          <input type="hidden" name="belongYear" value="'.$currentYear[$i].'">
          <input type="submit" name="act" value="newActivity">
        </form>';
      list($activityName,$belong,$belongYear,$crewMemberSheetw) = getActivity($groupId[$i],$currentYear[$i]);
      for($x =0;$x<count($activityName);$x++){
        echo $activityName[$x];
        echo '
          <form action = "controlAct.php" method="post">
            <input type="hidden" name="activityName" value="'.$activityName[$x].'"">
            <input type="hidden" name="belong" value="'.$belong[$x].'">
            <input type="hidden" name="belongYear" value="'.$belongYear[$x].'">
            <input type="submit" name="act" value="control">
          </form>';
      }
    }

  echo "完完完完完完完完完完完完";
  }

  // echo "<br>";
  // echo "-------------在某個群組下，開帖文------------------";
  // $type1id = "1YPIU7jCmaDj8Wt9ZlhwTfO9uTY_eyNeb";
  // 開帖文用的測試寫法，參考testtype
  // testtype1($type1id);

  // 取得置頂貼
  // $rt = getPinPost($type1id,1);
  // echo '
  //   <form action = "control.php" method="post">
  //     <input type="hidden" name="title" value="test2">
  //     <input type="hidden" name="posttype" value="1">
  //     <input type="hidden" name="id" value="'.$type1id.'">
  //     <input type="submit" name="act" value="explorer">
  //   </form>';

  // 檔案資料列出
  
}
// handOver("1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu",getEmail(),"106");
// refreshGroupPermission("1fvWi7jDch_hxiwYfJPH2aSIGCtFTQbzu");
if(isset($_SESSION['notCrew'])){
  echo "<br/>";
  echo "YOU ARE NOT CREW";
}else{
  echo "<br/>";
  echo "YOU ARE CREW";
}  
echo '
<form action="control.php" method="post">
  <input type="text" name="newYear" value="106"><br/>
  <input type="text" name="email" value="s104213070@mail1.ncnu.edu.tw"><br/>
  <input type="text" name="groupId" value="1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh"><br/>
  <input type="submit" name="act" value="handOver"><br/>
</form>
';
echo '
<form action="control.php" method="post">
	<input type="submit" name="act" value="logout"><br/>
</form>
';
// testCopy();
// var_dump(getFolderList("16Y8EK1a0bMjPjMxvVOxitWv3HRL-Olkk",2));
?>