<?php
require('model.php');
$action =$_REQUEST['act'];
switch ($action) {

case 'logout':
  // logout();
  getClient(1);
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
  // header('Location: viewDir.php');
  getFolderList($location,$type);
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

case 'appendData':
  session_start();
  $_SESSION['name']=$_REQUEST['name'];
  $_SESSION['email']=$_REQUEST['email'];
  $_SESSION['phone']=$_REQUEST['phone'];
  $_SESSION['position']=$_REQUEST['position'];
  $_SESSION['year']=$_REQUEST['year'];
  $fileId = appendData();
  break;

case 'selectItem':
  $_SESSION['fileId'] = $_REQUEST['fId'];
  $type = $_REQUEST['type'];
  if($type==1){
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
  }else if($type == 2){
    // first time pick up a folder
    $_SESSION['folderId'] = $_REQUEST['fId'];
    getFolderList('root',3);
  }else if($type == 3){
    // second time pick up a sheet file
    $_SESSION['sheetId']=$_REQUEST['fId'];
     echo $_SESSION['folderId'];
     echo $_SESSION['sheetId'];
    //separateCreateAndPermission($_SESSION['folderId'],$_SESSION['sheetId']);
    session_destroy();
  }
  // got file id now
  break;

case 'selectFirstSheet':
  $itemId = $_REQUEST['fId'];
  $type = $_REQUEST['type'];
  $rt = selectFirstSheet($itemId,$type);
  
  if($type==2){
    appendData2($_SESSION['name'],$_SESSION['email'],$_SESSION['phone'],$_SESSION['position'],$_SESSION['year'],$rt);
  }
  session_destroy();
  echo "selectFirstSheet".$rt;
  break;

case 'readDb':
  readDb();
  break;

case 'createFile':
  // for select a path to create file
  getFolderList('root',1);
  break;

case 'createFileToDrive':
  createFile($_REQUEST['type'],$_REQUEST['fileName'],$_SESSION['fileId']);
  session_destroy();
  break;
case 'separatePermission':
  getFolderList('root',2);
  break;

case 'listFolderTree':
  $pId=$_REQUEST['pId'];
  listFolderTree($pId,'0');
  break;
case 'whoami':
  $rt = getWho();
  echo $rt;
  break;

default :
  $rt = "nothing";
  echo $rt;
  break;
}
?>
