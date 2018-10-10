<?php
require('model.php');
$action =$_REQUEST['act'];
switch ($action) {
case 'getlist':
  $rt = getList();
  echo $rt;
  break;

case 'getFolderList':
  $location = $_REQUEST['pId'];
  $type = $_REQUEST['type'];
  // header('Location: viewDir.php');
  $rt = getFolderList($location,$type);
  echo $rt;
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
  echo $_SESSION['fileId'];
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
  getFolderList('root',1);
  break;
case 'createFileToDrive':
  echo 'get';
  createFile($_REQUEST['type'],$_REQUEST['fileName'],$_SESSION['fileId']);
  session_destroy();
  header();
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