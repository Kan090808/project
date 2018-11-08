<?php
require ('model.php');

$action = $_REQUEST['act'];
switch ($action) {

case 'allGroup':
  allGroup();
  break;

case 'approvedMember':
  $no = $_REQUEST['no'];
  $sheetId = $_REQUEST['sheetId'];
  $approvedStatus = approvedMember($no,$sheetId);
  break;

case 'choseExistsToPost':
  $title = $_REQUEST['title'];
  $type = $_REQUEST['type'];
  $belong = $_REQUEST['belong'];
  // $test = $_REQUEST['title'];
  // echo $test;
  if($title != ""){
    $_SESSION['tempTitle'] = $title;
  }
  choseExistsToPost($title,$type,$belong);
  break;

case 'clearChoseSession':
  unset($_SESSION['attach']);
  unset($_SESSION['newPostAttach']);
  unset($_SESSION['tempTitle']);
  header('Location: index.php');
  break;
case 'removeMember':
  $no = $_REQUEST['no'];
  $sheetId = $_REQUEST['sheetId'];
  $removeStatus = removeMember($no,$sheetId);
  break;

case 'logout':

  // logout();

  getClient(1);
  break;

case 'newMemberDetail':
  $name = $_REQUEST['name'];
  $id = $_REQUEST['id'];
  $department = $_REQUEST['department'];
  $email = $_REQUEST['email'];
  $gender = $_REQUEST['gender'];
  $class = $_REQUEST['class'];
  $year = $_REQUEST['year'];
  $tel = $_REQUEST['tel'];
  $diet = $_REQUEST['diet'];
  $skill = $_REQUEST['skill'];
  $prefer = $_REQUEST['prefer'];
  $groupId = $_REQUEST['groupId'];
  $status = 0;
  newMemberDetail($name,$id,$email,$gender,$class,$department,$year,$tel,$diet,$skill,$prefer,$groupId,$status);
  header('Location: index.php');
  break;

case 'newPostAttach':
  if($title != ""){
    $_SESSION['tempTitle'] = $title;
  }
  $title = $_REQUEST['title2'];
  $belong = $_REQUEST['belong'];
  $type = $_REQUEST['type'];
  $mime = $_REQUEST['newFileMime'];
  $array = array($title,$belong,$type,$mime);
  if(isset($_SESSION['newPostAttach'])){
    array_push($_SESSION['newPostAttach'], $array);
    header('Location: index.php');
  }else{
    $_SESSION['newPostAttach'] = array();
    array_push($_SESSION['newPostAttach'], $array);
    header('Location: index.php');
  }
  break;

case 'newPost':
  $title = $_REQUEST['title'];
  $belong = $_REQUEST['belong'];
  $type = $_REQUEST['type'];
  $mime = $_REQUEST['mime'];
  $attach = "";
  $newPostAttach = "";
  if($_REQUEST['attach'] != ""){
    $attach = unserialize(base64_decode($_REQUEST['attach']));  
  }
  if($_REQUEST['newPostAttach'] != ""){
    $newPostAttach = unserialize(base64_decode($_REQUEST['newPostAttach']));
  }
  // if($newPostAttach == ""){
  //   echo "nonewpostattach";
  // }
  // if($attach == ""){
  //   echo "noattach";
  // }
  newPost($title,$belong,$type,$mime,$newPostAttach,$attach);
  header('Location: index.php');
  break;

case 'searchGroup':
  $string = $_REQUEST['searchContent'];
  searchGroup($string);
  break;

case 'explorer':
  $title = $_REQUEST['title'];
  $folderId = $_REQUEST['id'];
  $posttype = $_REQUEST['posttype'];
  explorer($title,$posttype,$folderId);
  break;

case 'explorerFolderOnly':
  $title = $_REQUEST['title'];
  $folderId = $_REQUEST['id'];
  $posttype = $_REQUEST['posttype'];
  explorerFolderOnly($title,$posttype,$folderId);
  break;

case 'getClient':
  getClient(0);
  break;

case 'getlist':
  $rt = getList();
  echo $rt;
  break;

case 'getGroupShared':
  $location = $_REQUEST['gID'];
  getGroupShared($location);
  break;

case 'getFolderList':
  $location = $_REQUEST['pId'];
  $type = $_REQUEST['type'];
  getFolderList($location, $type);
  break;

case 'getShared':
  $rt = getShared();
  echo $rt;
  break;

case 'getMemberList':
  $rt = getMemberSheet(0);
  echo $rt;
  break;

case 'checkYearFolderExist':
  $rt = checkYearFolderExist();
  echo $rt;
  break;

case 'checkPositionFolderExist':
  $rt = checkPositionFolderExist();
  echo $rt;
  break;

case 'createFolderPermission':
  $rt = createFolderPermission();
  echo $rt;
  break;

case 'chosePathFile':
  $rt = chosePathFile();
  echo $rt;
  break;

case 'addData':
  appendData2($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['phoneNumber'], $_REQUEST['position'], $_REQUEST['group'], $_REQUEST['sheetId']);
  $groupId = getGroupId($_REQUEST['sheetId']);

  // echo $groupId;

  var_dump($groupId);

  // insertPermission($_REQUEST['email'],$_REQUEST['group'],$groupId);

  break;

case 'appendData':
  session_start();
  $_SESSION['name'] = $_REQUEST['name'];
  $_SESSION['email'] = $_REQUEST['email'];
  $_SESSION['phone'] = $_REQUEST['phone'];
  $_SESSION['position'] = $_REQUEST['position'];
  $_SESSION['year'] = $_REQUEST['year'];
  $fileId = appendData();
  break;

case 'deleteSheetData':
  deleteSheetData($_REQUEST['sheetId'], $_REQUEST['no']);
  break;

case 'selectItem':
  $_SESSION['fileId'] = $_REQUEST['fId'];
  $type = $_REQUEST['type'];
  if ($type == 1) {
    echo '
    <form action="control.php" method="post">
    create google file<br/>
      fileName
    <input type="text" name="fileName" value=""><br/>
      docs
    <input type="radio" name="type" value="doc"><br/>
      sheet
    <input type="radio" name="type" value="sheet"><br/>
      slide
    <input type="radio" name="type" value="slide"><br/>
      form
    <input type="radio" name="type" value="form"><br/>
    <input type="submit" name="act" value="createFileToDrive"><br/>
    </form>
    ';
  }
  else
  if ($type == 2) {

    // first time pick up a folder

    $_SESSION['folderId'] = $_REQUEST['fId'];
    getFolderList('root', 3);
  }
  else
  if ($type == 3) {

    // second time pick up a sheet file

    $_SESSION['sheetId'] = $_REQUEST['fId'];
    echo $_SESSION['folderId'];
    echo $_SESSION['sheetId'];

    // separateCreateAndPermission($_SESSION['folderId'],$_SESSION['sheetId']);

    session_destroy();
  }
  else
  if ($type == 4) {
    $fId = $_REQUEST['fId'];
    $title = $_REQUEST['title'];
    $belong = $_REQUEST['belong'];
    $posttype = $_REQUEST['posttype'];
    choseExistsToPost2($title,$fId,$belong,$posttype);
  }
  else
  if ($type == 5) {
    $fId = $_REQUEST['fId'];
    $title = $_REQUEST['title'];
    $belong = $_REQUEST['belong'];
    $posttype = $_REQUEST['posttype'];
    choseExistsToPost2($title,$fId,$belong,$posttype);
  }
  // got file id now

  break;

case 'selectFirstSheet':
  $itemId = $_REQUEST['fId'];
  $type = $_REQUEST['type'];
  $rt = selectFirstSheet($itemId, $type);
  if ($type == 2) {
    appendData2($_SESSION['name'], $_SESSION['email'], $_SESSION['phone'], $_SESSION['position'], $_SESSION['year'], $rt);
  }
  session_destroy();
  break;

case 'toCrew':
  $no = $_REQUEST['no'];
  $sheetId = $_REQUEST['sheetId'];
  addMemberToCrewSheet($no,$sheetId);
  break;

case 'readDb':
  readDb();
  break;

case 'createFile':

  // for select a path to create file

  getFolderList('root', 1);
  break;

case 'createFileToDrive':
  createFile($_REQUEST['type'], $_REQUEST['fileName'], $_SESSION['fileId']);
  session_destroy();
  break;

case 'separatePermission':
  getFolderList('root', 2);
  break;

case 'listFolderTree':
  $pId = $_REQUEST['pId'];
  listFolderTree($pId, '0');
  break;

case 'whoami':
  $rt = getWho();
  echo $rt;
  break;

case 'settingGroup':
  $gId = $_REQUEST['gId'];
  settingGroup($gId);
  break;

default:
  $rt = "nothing";
  echo $rt;
  break;
}

?>