<?php
if(!isset($_SESSION)) 
{ 
  session_start(); 
} 
require __DIR__ . '/vendor/autoload.php';

// $GLOBALS['client'] = getClient(0);
$GLOBALS['rootroot'] = "1gFdoJoNtjlABmjRYim5xEAXbLvnoIBLs";
if (isset($_POST['verCode'])) { //check if form was submitted
  $input = $_POST['verCode']; //get input text
}
function testCopy(){
  $service = new Google_Service_Drive(getClient(0));
  $dest = "1WQzSml-Yd1X3BPo-LSH5gdpMIcGEKwCh";
  $fileId = "1E3vmOJSFDd4T9AEIXrTqZC6YRNjyyCsiqRIoQEOi9Uw";
  $fileId2 = "1A8ei5AzBY79eRDNDC2vAHiGXt-NhAn9F17l2Tpdl6Xc";
  $emptyFileMetadata = new Google_Service_Drive_DriveFile();
  $file = $service->files->get($fileId, array('fields' => 'parents'));
  $previousParents = join(',', $file->parents);
  $file = $service->files->update($fileId, $emptyFileMetadata, array(
      'addParents' => $dest,
      'removeParents' => $previousParents,
      'fields' => 'id, parents'));
}
function testtype1($type1id)
{ 
  $title = "";
  if(isset($_SESSION['tempTitle'])){
    $title = $_SESSION['tempTitle'];
  }
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
      <input type="hidden" name="belong" value="'.$type1id.'">
      <input type="hidden" name="type" value="1">
      <input type="hidden" name="mime" value="doc">
      <input type="radio" name="newFileMime" value="doc"> doc
      <input type="radio" name="newFileMime" value="sheet"> sheet
      <input type="radio" name="newFileMime" value="slide"> slide
      <br>
      <input type="submit" name="act" value="newPostAttach">
      <input type="hidden" name="belong" value="'.$type1id.'">
      <input type="submit" name="act" value="choseExistsToPost">
      <input type="hidden" name="attach" value="'.$attach.'">
      <input type="hidden" name="newPostAttach" value="'.$newPostAttach.'">
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
  // 取出帖文
  list($postId,$postTitle,$postAttach,$isMainAttach)=getPost($type1id,2);
  for($x=0;$x<count($postId);$x++){
    if($isMainAttach[$x] == true){
      // var_dump($postAttach);
      echo "<br/>".$postTitle[$x]."___".$postAttach[$x];
      $link = getFileLink($postAttach[$x]);
      $emblink = getEmb($postAttach[$x]);
      echo "<a href='$link'>view/edit in docs</a><br/>";
      echo "<iframe src = '$emblink'></iframe>";
    }else{
      echo "<br/>帖文附件：".$postTitle[$x]."___".$postAttach[$x];
    } 
  }
}
function addMemberToCrewSheet($no, $membersheetId)
{
  $no = $no + 2;
  $name = array();
  $gmail = array();
  $tel = array();
  $position = array();
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = 'A' . $no . ':N' . $no;
  $response = $service->spreadsheets_values->get($membersheetId, $range);
  $values = $response->getValues();
  $position = array();
  $year = array();
  $parent;
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      echo $row[1];
    }
  }
}
function allGroup(){
  // if want to join, use insertMember.php
  // echo "
  //   <form method='post' action='insertMember.php'>
  //     <input type='hidden' name='email' value='".$email."'>
  //     <input type='hidden' name='groupId' value='".$groupId."'>
  //     <input type='submit' value = 'Apply to join this Group'>
  //   </form>";
  $email = getEmail();
  $searchResultGroupName = array();
  $searchResultGroupCurrentYear = array();
  $searchResultGroupId = array();
  $searchResultGroupIfJoined = array();
  $sql = "select * from `member`.`group`";
  $rt = getDb($sql,4);
  while ($row=mysqli_fetch_row($rt)){
    $status = checkIfJoinedThisGroup($row[2],$email);
    $groupId = $row[2];
    array_push($searchResultGroupName,$row[1]);
    array_push($searchResultGroupId,$row[2]);
    array_push($searchResultGroupCurrentYear,$row[4]);
    // $status state
    // null = no joined no apply
    // 0 = apply not accept
    // 1 = joined
    array_push($searchResultGroupIfJoined,$status);
  }
  return array($searchResultGroupId,$searchResultGroupName,$searchResultGroupCurrentYear,$searchResultGroupIfJoined);
}
function appendData()
{
  getMemberSheet(2);
}
function appendData2($name, $email, $phone, $position, $year, $fileId)
{
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  // DATE_RFC28222
  $time = date(DATE_RFC2822);
  $spreadsheetId = $fileId;
  $values = [[$time, $name, $email, $phone, $position, $year
  // Cell values ...
  ],
  // Additional rows ...
  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A2:F';
  $response = $service->spreadsheets_values->append($spreadsheetId, $range, $body, $params);
}
function appendDataToCrewMemberSheet($name, $email, $phone, $position, $actCrewSheetId){
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  // DATE_RFC28222
  $time = date(DATE_RFC2822);
  $values = [[$time, $name, $email, $phone, $position]];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A2:E';
  $response = $service->spreadsheets_values->append($actCrewSheetId, $range, $body, $params);
}
function approveApply($email,$groupName){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $role = 'writer';
  $userPermission = new Google_Service_Drive_Permission(array(
    'type' => 'user',
    'role' => $role,
    'emailAddress' => $email
  ));
  $sql = "update `member`.`apply` set status = '1' where applyGroupName='$groupName'";
  insertDb($sql);
  newGroup($groupName,$email);
  $request = $service->permissions->create($GLOBALS['rootroot'], $userPermission, array(
      'fields' => 'id'
  ));
}
function approvedMember($no, $sheetId)
{
  // echo $no.$groupId;
  $no = $no + 2;
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = 'N' . $no;
  $returnValue = "true";
  $valueInputOption = "USER_ENTERED";
  $value = [["1"]];
  $body = new Google_Service_Sheets_ValueRange(['values' => $value]);
  $params = ['valueInputOption' => $valueInputOption];
  try {
    $response = $service->spreadsheets_values->update($sheetId, $range, $body, $params);
  }
  //
  catch(Exception $e) {
    $returnValue = "false";
  }
  return $returnValue;
}
function checkMimeType($fileId){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $files = $service->files->get($fileId);
  $type = $files->getMimetype();
  return $type;
}
function checkLogin()
{
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    return "true";
  }
  else {
    return "false";
  }
}
function checkRole($email, $groupId)
{
  $sql = "select * from `member`.`useraccessiblegroup` where groupId='" . $groupId . "' and email='" . $email . "'";
  $rt = getDb($sql, 4);
  $role = false;
  while ($row = mysqli_fetch_row($rt)) {
    $role = $row[4];
  }
  return $role;
}
function copyFile($fileId, $path)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
}
function checkIfJoinedThisGroup($groupId, $email)
{
  // echo $groupId.$email;
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $sql = "select * from `member`.`group` where groupID = '" . $groupId . "'";
  $rt = getDb($sql, 4);
  $member_sheet_id = "";
  while ($row = mysqli_fetch_row($rt)) {
    $member_sheet_id = $row[5];
  }
  // check status value in member_sheet_id, compare via email
  $range = 'A2:N';
  $response = $service->spreadsheets_values->get($member_sheet_id, $range);
  $values = $response->getValues();
  if (empty($values)) {
    return "null";
  }
  else {
    foreach($values as $row) {
      if ($row[7] == $email) {
        $status = $row[13];
        return $status;
      }
      else {
        return "null";
      }
    }
  }
}
function checkIfCrewMemberInit($groupId){
  $sql = "select * from `member`.`group` where groupID='$groupId'";
  $rt = getDb($sql,4);
  $ifSet = "false";
  while ($row = mysqli_fetch_row($rt)) {
    if($row[3] != ""){
      $ifSet = "true";
    }
  }
  return $ifSet;
}
function checkYearFolderExist()
{
  getMemberSheet(1);
}
// function checkYearFolderExist2($fileId)
// {
//   // this function is called with a sheet file id
//   // get all year by sheet
//   // $client = getClient(0);
//   $service = new Google_Service_Sheets($GLOBALS['client']);
//   $currentYear = "105";
//   $secondLevelGroupId = "";
//   $rootroot = $GLOBALS['rootroot'];
//   $spreadsheetId = $fileId;
//   $response_title = $service->spreadsheets->get($spreadsheetId);
//   $about = json_encode($response_title, true);
//   $json = json_decode($about, true);
//   $title = $json['properties']['title'];
//   // range only include the F2:F year
//   $range = 'F2:F';
//   $response = $service->spreadsheets_values->get($spreadsheetId, $range);
//   $values = $response->getValues();
//   $year = array();
//   if (empty($values)) {
//     print "No data found.\n";
//   }
//   else {
//     foreach($values as $row) {
//       // judge if repeat
//       if (!array_key_exists($row[0], $year)) {
//         $temp = "$row[0]";
//         array_push($year, "$temp");
//       }
//     }
//     $year = array_unique($year);
//     $new_year = array_values($year);
//   }
//   // now had year data in $position
//   $notCreateYet = $new_year;
//   $service = new Google_Service_Drive($GLOBALS['client']);
//   $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$rootroot' in parents and trashed=false";
//   $results = $service->files->listFiles($parameters);
//   if (count($results->getFiles()) == 0) {
//     // print "checkYearFolderExist : No files found.\n";
//   }
//   else {
//     foreach($results->getFiles() as $file) {
//       $gotDir = false;
//       // check drive root folder if exist folder with those name
//       for ($i = 0; $i < count($new_year); $i++) {
//         // if(strcasecmp($position[$i],$file->getName())==0){
//         if ($new_year[$i] == $file->getName()) {
//           $gotDir = true;
//           $gotDirName = $new_year[$i];
//           unset($notCreateYet[$i]);
//         }
//         // now you had "notCreateYet" array that record which folder have not create
//       }
//     }
//     // var_dump($notCreateYet);
//   }
//   // create first level folder
//   $firstLevelId = createFolder($title, $rootroot, true, $spreadsheetId);
//   // create folder by $notCreateYet array
//   $notCreateYet = array_values($notCreateYet);
//   // create second level folder
//   if (count($notCreateYet) > 0) {
//     for ($i = 0; $i < count($notCreateYet); $i++) {
//       // echo $notCreateYet[$i];
//       // create 104 105
//       $folderId = createFolder($notCreateYet[$i], $firstLevelId, false, $spreadsheetId);
//       // echo "------".$folderId;
//       // get id of folder you had just create
//       createGroupFolderPermission($firstLevelId, $folderId, $fileId);
//       createGroupFolderPermissionEditor($folderId);
//       // 創立了 xx會-xx年-組別，回傳“組別”文件夾的id
//       $secondLevelGroupId = createFolder("組別", $folderId, false, $spreadsheetId);
//     }
//   }
//   // 利用xx組別文件夾的id，底下產生職位組別
//   checkPositionFolderExist2($spreadsheetId,$firstLevelId ,$secondLevelGroupId,$currentYear);
// }
function checkYearFolderExist2($fileId,$folderId)
{
  // this function is called with a sheet file id
  // get all year by sheet
  // $client = getClient(0);
  $service = new Google_Service_Sheets($GLOBALS['client']);
  $currentYear = "105";
  $secondLevelGroupId = "";
  $rootroot = $GLOBALS['rootroot'];
  $spreadsheetId = $fileId;
  $response_title = $service->spreadsheets->get($spreadsheetId);
  $about = json_encode($response_title, true);
  $json = json_decode($about, true);
  $title = $json['properties']['title'];
  // range only include the F2:F year
  $range = 'F2:F';
  $response = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $year = array();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      // judge if repeat
      if (!array_key_exists($row[0], $year)) {
        $temp = "$row[0]";
        array_push($year, "$temp");
      }
    }
    $year = array_unique($year);
    $new_year = array_values($year);
  }
  // now had year data in $position
  $notCreateYet = $new_year;
  $service = new Google_Service_Drive($GLOBALS['client']);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$rootroot' in parents and trashed=false";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    // print "checkYearFolderExist : No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      $gotDir = false;
      // check drive root folder if exist folder with those name
      for ($i = 0; $i < count($new_year); $i++) {
        // if(strcasecmp($position[$i],$file->getName())==0){
        if ($new_year[$i] == $file->getName()) {
          $gotDir = true;
          $gotDirName = $new_year[$i];
          unset($notCreateYet[$i]);
        }
        // now you had "notCreateYet" array that record which folder have not create
      }
    }
    // var_dump($notCreateYet);
  }
  // create first level folder
  // $firstLevelId = createFolder($title, $rootroot, true, $spreadsheetId);
  $firstLevelId = $folderId;
  // create folder by $notCreateYet array
  $notCreateYet = array_values($notCreateYet);
  // create second level folder
  if (count($notCreateYet) > 0) {
    for ($i = 0; $i < count($notCreateYet); $i++) {
      // echo $notCreateYet[$i];
      // create 104 105
      $folderId = createFolder($notCreateYet[$i], $firstLevelId, false, $spreadsheetId);
      // echo "------".$folderId;
      // get id of folder you had just create
      createGroupFolderPermission($firstLevelId, $folderId, $fileId);
      createGroupFolderPermissionEditor($folderId);
      // 創立了 xx會-xx年-組別，回傳“組別”文件夾的id
      $secondLevelGroupId = createFolder("組別", $folderId, false, $spreadsheetId);
    }
  }
  // 利用xx組別文件夾的id，底下產生職位組別
  checkPositionFolderExist2($spreadsheetId,$firstLevelId ,$secondLevelGroupId,$currentYear);
}
// clear
function checkPositionFolderExist()
{
  getMemberSheet(3);
}
// for position
function checkPositionFolderExist2($fileId, $firstLevelId,$secondLevelGroupId,$currentYear)
{
  // check each row position's year
  // get all position name by sheet
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;
  $range = "E2:F";
  // range only include the position
  $response = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $position = array();
  $year = array();
  $parent;
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    // problem here : how to get parent folder
    // name,folderid;
    foreach($values as $row) {
      $positionValue = $row[0];
      $yearValue = $row[1];
      $yearId = getFolderId($yearValue, $firstLevelId);
      array_push($position, $positionValue);
      array_push($year, $yearId);
      // 得到 職位名字，該存在的位置ID
    }
  }
  $notCreateYetPosition = array();
  $notCreateYetYear = array();
  $thirdLayerId = array();
  $judge = array();
  // 先判斷
  for ($i = 0; $i < count($position); $i++) {
    // 把職位和年份合在一起成 $t
    // 方便判斷有沒有職位和年份互相衝突
    $thirdLayer = getFolderId("組別",$year[$i]);
    $t = $position[$i] . "+" . $thirdLayer;
    if (in_array($t, $judge) == false) {
      
      array_push($judge, $t);
      array_push($notCreateYetPosition, $position[$i]);
      array_push($notCreateYetYear, $thirdLayer);
      // echo "AA".$position[$i]."BB".$thirdLayer;
    }
  }
  for ($i = 0; $i < count($notCreateYetPosition); $i++) {
    // 創立了 xx會-xx年-組別-“xx群” 
    if(!in_array($notCreateYetPosition[$i], array("社長","副社長","顧問"))){
      createFolder($notCreateYetPosition[$i], $notCreateYetYear[$i], false, $spreadsheetId);
    }
    // createFolder($notCreateYetPosition[$i], $firstLevelId, false, $spreadsheetId);
  }
  createFolderPermission($firstLevelId, $spreadsheetId,$currentYear);
}
function choseExistsToPost($title,$posttype,$belong){
  explorer($title,$posttype,$belong);
}
function choseExistsToPost2($title,$fileId,$belong,$posttype){
  $array = array($title,$fileId,$belong,$posttype);
  if(isset($_SESSION['attach'])){
    array_push($_SESSION['attach'], $array);
    header('Location: index.php');
  }else{
    $_SESSION['attach'] = array();
    array_push($_SESSION['attach'], $array);
    header('Location: index.php');
  }
}
function copyMemberToCrew($name,$email,$phone,$position,$currentYear,$role,$crewSheet){
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  // DATE_RFC28222
  $time = date(DATE_RFC2822);
  $values = [[$time, $name, $email, $phone, $position, $currentYear,$role]];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A2:E';
  $response = $service->spreadsheets_values->append($crewSheet, $range, $body, $params);
}
function createFolder($name, $folderId, $isOnRoot, $spreadsheetId)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => $name,
    'mimeType' => 'application/vnd.google-apps.folder',
    'parents' => array(
      $folderId
    )
  ));
  $results = $service->files->create($fileMetadata, array(
    'fields' => 'id'
  ));
  $driveId = $results->getId();
  if ($isOnRoot == true) {
    // change create new membersheetid ->>>
    // copy template(form,sheet)
    $membersheetId = createFile("sheet", "memberSheet", $driveId);
    // $membersheetId = copyFile(file,$driveId);
    // $memberformId = copyFile(file,$driveId);
    // $sql = "insert into `member`.`group` (groupName, groupID, crew_sheet_id,member_sheet_id,member_form_id) VALUES ('$name','$driveId','$spreadsheetId','$membersheetId','$memberformId')";
    $sql = "insert into `member`.`group` (groupName, groupID, crew_sheet_id,member_sheet_id) 
          VALUES ('$name','$driveId','$spreadsheetId','$membersheetId')";
    insertDb($sql);
    initMemberSheet($membersheetId);
  }
  return $results->getId();
}
function createFolderPermission($parentId, $fileId, $currentYear)
{
  // echo $parentId.$fileId;
  $client = getClient(0);
  $client_s = getClientSheet();
  $service = new Google_Service_Drive($client);
  $service_s = new Google_Service_Sheets($client_s);
  $spreadsheetId = $fileId;
  $range = 'A2:G';
  // 2 & 4
  $response = $service_s->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $role = 'writer';
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      // usermail == 2 , position == 4
      $userEmail = $row[2];
      $position = $row[4];
      $year = $row[5];
      $roleString = $row[6];
      $roleNum;
      if(strcmp($roleString, "社長") ==0){
        $roleNum = 99;
      }else if(strcmp($roleString, "副社長") ==0){
        $roleNum = 98;
      }else if(strcmp($roleString, "組長") ==0){
        $roleNum = 89;
      }else if(strcmp($roleString, "組員") ==0){

        $roleNum = 88;
      }else if(strcmp($roleString, "顧問") ==0){
        $roleNum = 79;
      } else {
        $roleNum = 60;
      }
      if(!in_array($roleString, array("社長","副社長","顧問")) && $currentYear==$year){
        // xxgroup - 105
        $yId = getFolderId($year, $parentId);
        // echo "yid=".$yId;
        // xxgroup - 105 - zubie
        $thirdLayer = getFolderId("組別",$yId);
        // echo "thirdLayer=".$thirdLayer;
        // xxgroup - 105 - zubie - wenshu
        $poId = getFolderId($position, $thirdLayer);
        // echo $position."poID".$poId;
        
        $userPermission = new Google_Service_Drive_Permission(array(
          'type' => 'user',
          'role' => $role,
          'emailAddress' => $userEmail
        ));
        $request = $service->permissions->create($poId, $userPermission, array(
          'fields' => 'id'
        ));
        $sql = "insert into `member`.`user` (email) 
          Select * from (select '$userEmail') AS tmp
          where not exists(select email from `member`.`user` where email = '$userEmail')";
        $sql2 = "insert into `member`.`useraccessiblegroup` (email,groupID) 
          Select * from (select '$userEmail','$parentId') AS tmp2
          where not exists(select email from `member`.`useraccessiblegroup` where email = '$userEmail')";
        $sqlTest = "insert into `member`.`useraccessiblegroup` (email,groupID,year,role) values ('$userEmail','$parentId','$year','$roleNum')";
        $sql3 = "select * from `member`.`useraccessiblegroup` where email = '$userEmail' and groupID = '$parentId' and year='$year' and role='$roleNum'";
        $result = getDb($sql3, 4);
        if (mysqli_num_rows($result) == 0) {
          insertDb($sqlTest);
        }
        insertDb($sql);
      }else{
        if($currentYear != $year){
          // echo $userEmail;
          $role = "reader";
        }else{
          $role = "writer";
        }
        $userPermission = new Google_Service_Drive_Permission(array(
          'type' => 'user',
          'role' => $role,
          'emailAddress' => $userEmail
        ));
        $request = $service->permissions->create($parentId, $userPermission, array(
          'fields' => 'id'
        ));
        $sql = "insert into `member`.`user` (email) 
          Select * from (select '$userEmail') AS tmp
          where not exists(select email from `member`.`user` where email = '$userEmail')";
        $sql2 = "insert into `member`.`useraccessiblegroup` (email,groupID) 
          Select * from (select '$userEmail','$parentId') AS tmp2
          where not exists(select email from `member`.`useraccessiblegroup` where email = '$userEmail')";
        $sqlTest = "insert into `member`.`useraccessiblegroup` (email,groupID,year,role) values ('$userEmail','$parentId','$year','$roleNum')";
        $sql3 = "select * from `member`.`useraccessiblegroup` where email = '$userEmail' and groupID = '$parentId' and year='$year' and role='$roleNum'";
        $result = getDb($sql3, 4);
        if (mysqli_num_rows($result) == 0) {
          insertDb($sqlTest);
        }
        insertDb($sql);
      }
    }
  }
  // delete the illegal permission id come from inherit
  // $service->permissions->delete($folderId, $permissionId);
}
// createGroupFolderPermission is for create father/group folder permission
// if not create permission on father folder, unable to browser/list child folder
// eventhought you had child folder permission
function createGroupFolderPermissionEditor($folderId){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $role = 'writer';
  $userPermission = new Google_Service_Drive_Permission(array(
    'type' => 'user',
    'role' => $role,
    'emailAddress' => 'oldfishstudent108@gmail.com'
  ));
  $request = $service->permissions->create($folderId, $userPermission, array(
    'fields' => 'id'
  ));
}
function createGroupFolderPermission($parentId, $folderId, $sheetId)
{
  $client = getClient(0);
  $client_s = getClientSheet();
  $service = new Google_Service_Drive($client);
  $service_s = new Google_Service_Sheets($client_s);
  $spreadsheetId = $sheetId;
  $range = 'A2:F';
  $position = array();
  // 2 & 5 , email and year
  $response = $service_s->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $role = 'reader';
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      $userEmail = $row[2];
      $positionTemp = $row[5];
      array_push($position, $positionTemp);
      // $fileId         = getFolderId($row[5],$parentId);
      $role = "reader";
      $userPermission = new Google_Service_Drive_Permission(array(
        'type' => 'user',
        'role' => $role,
        'emailAddress' => $userEmail
      ));
      $request = $service->permissions->create($parentId, $userPermission, array(
        'fields' => 'id'
      ));
    }
  }
}
function createFile($act, $newFileName, $pid)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  // $pid = '1KFFRE62gtj2sdkSXjm17aMChz31-qH4b';
  if ($act == "doc") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.document'
    ));
  }
  else if ($act == "sheet") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.spreadsheet'
    ));
  }
  else if ($act == "slide") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.presentation'
    ));
  }
  else if ($act == "form") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.form'
    ));
  }
  else if ($act == "folder") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.folder'
    ));
  }
  else {
    return "error";
  }
  if (isset($fileMetadata)) {
    $file = $service->files->create($fileMetadata, array(
      'fields' => 'id'
    ));
    return $file->id;
    // printf("File ID: %s\n", $file->id);
  }
}
function deleteSheetData($sheetId, $no)
{
  $client = getClientSheet();
  $service = new Google_Service_Sheets($client);
  $range = "A" . $no . ":F" . $no . "";
  $requestBody = new Google_Service_Sheets_ClearValuesRequest();
  $response = $service->spreadsheets_values->clear($sheetId, $range, $requestBody);
}
function expandHomeDirectory($path)
{
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory) , $path);
}
function editFilePermission($fileId)
{
  echo "editFilePermission";
}
function explorer($title,$posttype,$belong){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  // $parameters['q'] = "'$belong' in parents and trashed=false";
  $optParams = array(
    'pageSize' => 50,
    'fields' => "files(id,name,size,mimeType,modifiedTime)",
    'orderBy' => "folder",
    'q' => "'" . $belong . "' in parents and trashed=false"
  );
  $results = $service->files->listFiles($optParams);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      if($file->getMimetype() =="application/vnd.google-apps.folder"){
        $folderId = $file->getId();
        echo '<br/>';
        echo '<a href="control.php?act=explorer&title='.$title.'&id='.$folderId.'&posttype='.$posttype.'">'."[folder]".$file->getName().'</a>';
      }else{
        $fileId = $file->getId();
        echo '<br/>';
        echo '<a href="control.php?act=selectItem&type=4&posttype='.$posttype.'&fId='.$fileId.'&title='.$title.'&belong='.$belong.'">'.$file->getName().'</a>';
      }
    }
  }
}
function explorerFolderOnly($title,$posttype,$belong){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  // $parameters['q'] = "'$belong' in parents and trashed=false";
  $optParams = array(
    'pageSize' => 50,
    'fields' => "files(id,name,size,mimeType,modifiedTime)",
    'orderBy' => "folder",
    'q' => "mimeType = 'application/vnd.google-apps.folder' and '" . $belong . "' in parents and trashed=false"
  );
  $results = $service->files->listFiles($optParams);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      $folderId = $file->getId();
      echo '<br/>';
      echo '<a href="control.php?act=selectItem&type=5&posttype='.$posttype.'&fId='.$fileId.'&title='.$title.'&belong='.$belong.'">'."[folder]".$file->getName().'</a>';
    }
  }
}
function getApplyGroup(){
  $applicantEmail = array();
  $applyGroupName = array();
  $status = array();
  $sql = "select * from `member`.`apply`";
  $rt = getDb($sql,4);
  while ($row = $rt->fetch_assoc()) {
    array_push($applicantEmail,$row["applicantEmail"]);
    array_push($applyGroupName,$row["applyGroupName"]);
    array_push($status,$row["status"]);
  }
  return array($applicantEmail,$applyGroupName,$status);
}
function getActivity($groupId,$currentYear){
  $actname = array();
  $belong = array();
  $belongYear = array();
  $crewMemberSheet = array();
  $sql = "select * from `member`.`activity` where belong='$groupId' and belongYear = '$currentYear'";
  $rt = getDb($sql,4);
  while ($row = $rt->fetch_assoc()) {
    array_push($actname, $row['activityName']);
    array_push($belong, $row['belong']);
    array_push($belongYear, $row['belongYear']);
    array_push($crewMemberSheet, $row['crewMemberSheet']);
  }
  return array($actname,$belong,$belongYear,$crewMemberSheet);
}
function getActivityCrewMember($activityName,$belong,$belongYear)
{
  $sql = "select * from `member`.`activity` where activityName='$activityName' and belong='$belong' and belongYear='$belongYear'";
  $actCrewSheet = "";
  // echo $sql;
  $rt = getDb($sql,4);
  // var_dump($rt);
  while ($row = $rt->fetch_assoc()) {
    $actCrewSheet = $row["crewMemberSheet"];
  }
  return $actCrewSheet;
}
function getActIdBySheet($actCrewSheet){
  $sql = "select * from `member`.`activity` where crewMemberSheet='" . $actCrewSheet . "'";
  $rt = getDb($sql, 4);

}
function getClient($type)
{
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->setAuthConfig('../html/webClient.json');
  $client->addScope("https://www.googleapis.com/auth/drive");
  $client->setAccessType('offline');
  $client->setApprovalPrompt('force');
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  }
  else {
    if ($_SERVER['HTTP_HOST'] == "163.22.17.92") {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '.nip.io/html/oauth2callback.php';
    }
    else {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/html/oauth2callback.php';
    }
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }
  if ($client->isAccessTokenExpired()) {
    session_unset();
    session_destroy();
    session_unset();
    $client->revokeToken();
    // header('Location: ../html/index.php');
    // $refreshToken = $client->getRefreshToken();
    // $client->refreshToken($refreshToken);
  }
  else {
  }
  if ($type == 1) {
    session_unset();
    session_destroy();
    session_unset();
    $client->revokeToken();
    header('Location: ../website/index.php');
  }
  else {
    return $client;
  }
}
function getClientReadOnly()
{
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->setAuthConfig('../html/webClient.json');
  $client->addScope("https://www.googleapis.com/auth/drive.readonly");
  $client->setAccessType('offline');
  $client->setApprovalPrompt('force');
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  }
  else {
    if ($_SERVER['HTTP_HOST'] == "163.22.17.92") {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '.nip.io/html/oauth2callback.php';
    }
    else {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/html/oauth2callback.php';
    }
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }
  if ($client->isAccessTokenExpired()) {
    // $refreshToken = $client->getRefreshToken();
    // $client->refreshToken($refreshToken);
    session_unset();
    session_destroy();
    session_unset();
    $client->revokeToken();
  }
  return $client;
}
function getClientSheet()
{
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->setAuthConfig('webClient.json');
  $client->addScope("https://www.googleapis.com/auth/spreadsheet");
  $client->setAccessType('offline');
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  }
  else {
    if ($_SERVER['HTTP_HOST'] == "163.22.17.92") {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '.nip.io/html/oauth2callback.php';
    }
    else {
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/html/oauth2callback.php';
    }
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }
  if ($client->isAccessTokenExpired()) {
    // $refreshToken = $client->getRefreshToken();
    // $client->refreshToken($refreshToken);
    session_unset();
    session_destroy();
    session_unset();
    $client->revokeToken();
  }
  // if ($client->isAccessTokenExpired()) {
  //   $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
  //   file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  // }
  return $client;
}
function getCurrentYearGroup($groupId, $currentYear)
{
  return getFolderId($currentYear, $groupId);
}
function getCurrentLocationPost($location,$type){
  // type 1 =normal,folderid | 2 = intro,groupId | 3 = notice,groupId

}
function getDb($sql, $type)
{
  //  echo $sql.$type;
  $servername = "localhost";
  $username = "kan";
  $password = "15110215";
  $conn = new mysqli($servername, $username, $password);
  mysqli_set_charset($conn,"utf8");

  $temp = array();
  $result = $conn->query($sql);
  if ($type == 1) {
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        // echo "<br />"."accessible groupID: " . $row["groupID"];
        array_push($temp, $row["groupID"]);
      }
      return $temp;
      reset($temp);
    }
    else {
      echo "0 results";
    }
  }
  else if ($type == 2) {
    $groupName = array();
    $groupId = array();
    $currentYear = array();
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        // echo "<br />" . "in group: " . $row["groupName"];
        array_push($groupName, $row["groupName"]);
        array_push($groupId, $row["groupID"]);
        array_push($currentYear, $row["currentYear"]);
      }
      return array(
        $groupName,
        $groupId,
        $currentYear
      );
    }
    else {
      echo "0 results";
    }
  }
  else if ($type == 3) {
    if (!$result) {
      trigger_error('Invalid query: ' . $conn->error);
    }
    if ($result->num_rows > 0 && $result->num_rows < 2) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        $sheetId = $row["crew_sheet_id"];
        return $sheetId;
      }
    }
    else {
      echo "0 results or more that one result";
    }
  }
  else if ($type == 4) {
    return $result;
  }
  $conn->close();
}
function getEmail()
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $optParams = array(
    'fields' => 'user(emailAddress)'
  );
  try {
    $about = $service->about->get($optParams);
    $about = json_encode($about, true);
    $json = json_decode($about, true);
    $email = $json['user']['emailAddress'];
    return $email;
  }
  catch(Exception $e) {
    echo "error";
    print "An error occurred: " . $e->getMessage();
  }
}
function getEmb($fileId){
  // 取巧寫法，變成是要去判斷他是什麼type
  // spreadsheet = "https://docs.google.com/spreadsheets/d/".$fileId."/preview";
  // doc = "https://docs.google.com/document/d/".$fileId."/preview";
  // slide = "https://docs.google.com/presentation/d/".$fileId."/preview";
  $type = checkMimeType($fileId);
  $emb;
  if($type == "application/vnd.google-apps.document"){
    $emb = "https://docs.google.com/document/d/".$fileId."/preview";

  }else if($type == "application/vnd.google-apps.spreadsheet"){
    $emb = "https://docs.google.com/spreadsheets/d/".$fileId."/preview";
  
  }else if($type == "application/vnd.google-apps.presentation"){
    $emb = "https://docs.google.com/presentation/d/".$fileId."/preview";
  }
  return $emb;
}
function getFileLink($fileId){
  $type = checkMimeType($fileId);
  $link;
  if($type == "application/vnd.google-apps.document"){
    $link = "https://docs.google.com/document/d/".$fileId;

  }else if($type == "application/vnd.google-apps.spreadsheet"){
    $link = "https://docs.google.com/spreadsheets/d/".$fileId;
  
  }else if($type == "application/vnd.google-apps.presentation"){
    $link = "https://docs.google.com/presentation/d/".$fileId;
  }
  return $link;
}
function getFolderList($location, $type)
{
  // echo $location;
  // type 1 for select folder to create file function
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  // $parameters['q'] = "'$location' in parents and trashed=false";
  // $results = $service->files->listFiles($parameters);
  $optParams = array(
    'pageSize' => 50,
    'fields' => "nextPageToken, files(id,name,size,mimeType,modifiedTime)",
    'q' => "'" . $location . "' in parents"
  );
  $results = $service->files->listFiles($optParams);
  if (count($results->getFiles()) == 0) {
    // print "getFolderList : No files found.\n";
    echo "this dir has no folder";
    $preLoc = getParent($service, $location);
    echo "
    <form method='post' action='control.php'>
      <input type='hidden' name='act' value='getFolderList'>
      <input type='hidden' name='type' value='$type'>
      <input type='hidden' name='pId' value='$preLoc'>
      <input type='submit' value = 'back to previous'>
    </form>";
    echo "
    <form method='post' action='controlMenu.php'>
      <input type='submit' value = 'back to menu'>
    </form>";
  }
  else {
    // listFolderTree($location, 1);
    // echo "<br/>" . "上面是當前list，你可以呼叫在左邊當導航欄";
    if ($type == 1) {
      foreach($results->getFiles() as $file) {
        // printf("%s ", $file->getName());
        $fileName = $file->getName();
        // 1jvBKzL5xKPXhCapPhfdPWes0pPr6MWFT
        $fileId = $file->getId();
        if ($file->getMimeType() == "application/vnd.google-apps.folder") {
          echo "<br />\n";
          echo "<a href='control.php?act=getFolderList&pId=$fileId&type=$type'>$fileName</a>";
        }
        else {
          echo "<br />\n";
          echo $fileName;
          echo "<a href='control.php'>this is file, openIt</a>";
        }
      }
      echo "<br />";
      editFilePermission($location);
    }
    else if ($type == 2) {
      //echo "hihihihihihihihih";
      $fileName = array();
      $fileId = array();
      $fileType = array();
      $fileLastMod = array();
      $fileSize = array();
      foreach($results->getFiles() as $file) {
        array_push($fileName, $file->getName());
        array_push($fileId, $file->getId());
        array_push($fileType, $file->getMimetype());
        array_push($fileLastMod, $file->getModifiedTime());
        array_push($fileSize, $file->getSize());
      }
      return array(
        $fileName,
        $fileId,
        $fileType,
        $fileLastMod,
        $fileSize
      );
    }
    else {
      $preLoc = getParent($service, $location);
      echo "
      <form method='post' action='control.php'>
        <input type='hidden' name='act' value='getFolderList'>
        <input type='hidden' name='type' value='$type'>
        <input type='hidden' name='pId' value='$preLoc'>
        <input type='submit' value = 'back to previous'>
      </form>";
      echo "
      <form method='post' action='controlMenu.php'>
        <input type='submit' value = 'back to menu'>
      </form>";
      foreach($results->getFiles() as $file) {
        if ($file->getMimeType() == "application/vnd.google-apps.folder") {
          echo "<br />\n";
          // printf("%s ", $file->getName());
          $fileName = $file->getName();
          // 1jvBKzL5xKPXhCapPhfdPWes0pPr6MWFT
          $fileId = $file->getId();
          echo "<a href='control.php?act=getFolderList&pId=$fileId&type=$type'>$fileName</a>";
          echo "
          <form method='post' action='control.php'>
            <input type='hidden' name='act' value='selectItem'>
            <input type='hidden' name='fId' value='$fileId'>
            <input type='hidden' name='type' value='$type'>
            <input type='submit' value = 'select this folder'>
          </form>";
        }
      }
      echo "------------File in this DIR-----------";
      echo "<br/>";
      echo getListInDir($location, $type);
    }
  }
}
function getFolderId($name, $folderId)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$folderId' in parents and trashed=false and (name = '$name')";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    return null;
  }
  if (count($results->getFiles()) > 1) {
    echo $name."more that one";
  }
  else {
    foreach($results->getFiles() as $file) {
      return $file->getId();
    }
  }
}
function getGroupShared($folderId)
{
  // folderId is "104" id
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  // $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$folderId' in parents and trashed=false ";
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and sharedWithMe and trashed=false ";
  $results = $service->files->listFiles($parameters);
  $allSharedFileId = array();
  $allSharedFileName = array();
  // now you get alot of file that in your sharedWithMe
  // filter them with their parent id, if their parent id is "104" folder id
  // then this is the file that you want
  if (count($results->getFiles()) == 0) {
    print "getShared : No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        array_push($allSharedFileId, $file->getId());
      }
    }
    // now you get a array with all sharedFileID , $allSharedFileId
    // echo "<br/>".count($allSharedFileId)."<br/>";
    for ($i = 0; $i < count($allSharedFileId); $i++) {
      $eachSharedId = $allSharedFileId[$i];
      // echo $folderId;
      // echo "<br/>".$i."-----".$eachSharedId."<br/>";
      // both value is ok
      ifInFolder($service, $folderId, $eachSharedId);
    }
  }
}
function getGroupCrewSheet($groupId)
{
  $sql = "select * from `member`.`group` where groupID='" . $groupId . "'";
  return getDb($sql, 3);
}
function getGroupMemberSheet($groupId)
{
  $sql = "select * from `member`.`group` where groupID='" . $groupId . "'";
  $rt = getDb($sql, 4);
  $member_sheet_id = "";
  while ($row = mysqli_fetch_row($rt)) {
    $member_sheet_id = $row[5];
  }
  return $member_sheet_id;
}
function getGroupId($sheetId)
{
  $sql = "select groupID from `member`.`group` where crew_sheet_id='" . $sheetId . "'";
  return getDb($sql, 4);
}
function getJoinedGroup($email)
{
  $f = array();
  $s = array();
  $c = array();
  $sql = "Select * from `member`.`useraccessiblegroup` where email='$email'; ";
  $accessible = array();
  $joinedGroupId = array();
  $joinedGroupYear = array();
  $accessible = getDb($sql, 4);
  while ($row = mysqli_fetch_row($accessible)) {
    array_push($joinedGroupId, $row[2]);
    array_push($joinedGroupYear, $row[3]);
  }
  if (count($joinedGroupId) != 0) {
    for ($i = 0; $i < count($joinedGroupId); $i++) {
      $value = $joinedGroupId[$i];
      $sql2 = "select * from `member`.`group` where groupID='$value'";
      list($ff, $ss, $cc) = getDb($sql2, 2);
      for ($x = 0; $x < count($ff); $x++) {
        array_push($f, $ff[$x]);
        array_push($s, $ss[$x]);
        array_push($c, $cc[$x]);
      }
    }
    return array(
      $f,
      $s,
      $c
    );
  }
  else {
    $_SESSION['notCrew'] = "true";
  }
}
function getList()
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $optParams = array(
    'pageSize' => 100,
    'fields' => 'nextPageToken, files(id, name, mimeType)'
  );
  $results = $service->files->listFiles($optParams);
  // $about = $service->about->get();
  // echo $about->getName();
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      echo "<br />\n";
      printf("%s (%s) [%s]", $file->getName() , $file->getId() , $file->getMimeType());
    }
  }
}
function getListInDir($location, $type)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType!='application/vnd.google-apps.folder' and '$location' in parents and trashed=false";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      echo "<br />\n";
      printf("%s", $file->getName());
      $fileId = $file->getId();
      echo "
        <form method='post' action='control.php'>
          <input type='hidden' name='act' value='selectItem'>
          <input type='hidden' name='type' value='$type'>
          <input type='hidden' name='fId' value='$fileId'>
          <input type='submit' value = 'select this file'>
        </form>";
    }
  }
}
function getMemberList($fileId)
{
  // ok
  $client = getClientSheet();
  // ok
  $service = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;
  // echo $spreadsheetId;
  // ok
  // $spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
  $range = 'A2:F';
  $response = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      if ($type == 0) {
        echo "<br />\n";
        // name and position
        printf("%s, %s, %s", $row[1], $row[4], $row[5]);
      }
      else if ($type == 1) {
      }
    }
  }
}
function getMemberSheet($type)
// use to find memberSheet file in drive

{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.spreadsheet' and trashed=false";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      echo $file->getName();
      echo "<br/>";
      echo $file->getId();
      $fileId = $file->getId();
      echo "
        <form method='post' action='control.php'>
          <input type='hidden' name='act' value='selectFirstSheet'>
          <input type='hidden' name='fId' value='$fileId'>
          <input type='hidden' name='type' value='$type'>
          <input type='submit' value = 'select this file'>
        </form>";
      echo "<br/>";
    }
  }
}
function getName()
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $optParams = array(
    'fields' => 'user(displayName)'
  );
  try {
    $about = $service->about->get($optParams);
    // var_dump($about);
    $about = json_encode($about, true);
    $json = json_decode($about, true);
    $name = $json['user']['displayName'];
    return $name;
  }
  catch(Exception $e) {
    echo "error";
    print "An error occurred: " . $e->getMessage();
  }
}
function getParent($service, $fileId)
{
  $optParams = array(
    'fields' => "name, parents",
  );
  $file_parent = $service->files->get($fileId, $optParams);
  // var_dump($file_parent);
  $temp = json_encode($file_parent, true);
  $json = json_decode($temp, true);
  $parent = $json['parents'][0];
  // var_dump($json);
  // echo "parent id : ".$parent;
  return $parent;
}
function getShared()
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and trashed=false 
  and sharedWithMe and (name contains '[project]')";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "getShared : No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        echo "<br />\n";
        printf("%s (%s) [%s]", $file->getName() , $file->getId() , $file->getMimeType());
      }
    }
  }
}
function getPermissionList($fileId,$email){
  // list permission of a fileId by email
  $permissionList = array();
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $optParams = array(
    'fields' => "name, permissionIds",
  );
  $results = $service->files->get($fileId, $optParams);
  $temp = json_encode($results, true);
  $json = json_decode($temp, true);
  for($i = 0 ;$i<count($json['permissionIds']);$i++){
    array_push($permissionList, $json['permissionIds'][$i]);
  }
  return $permissionList;
}
function getPost($belong,$type){
  $postBy = array();
  $postId = array();
  $postFileId = array();
  $postTitle = array();
  $postTitle2 = array();
  $mainAttach = array();
  $postAttach2 = array();
  $postId2 = array();
  $isPostMainAttach = array();
  $sql = "select * from `member`.`post` where belong = '".$belong."' and type = '".$type."'";
  $rt = getDb($sql,4);
  while ($row = $rt->fetch_assoc()) {
    array_push($postId,$row["id"]);
    array_push($postFileId,$row["fileId"]);
    array_push($mainAttach,$row["fileId"]);
    array_push($postTitle,$row["title"]);
    array_push($postBy,$row["postBy"]);
     
  }
  for($i=0;$i<count($postId);$i++){
    $sql = "select * from `member`.`postattach` where postId = '".$postId[$i]."'";
    $rt2 = getDb($sql,4);
    while ($row2 = $rt2->fetch_assoc()){
      if($row2["attachId"]==$postFileId[$i]){
        // echo "<br>ttt".$row2["attachId"].$postFileId[$i];
        array_push($isPostMainAttach,true);
      }else{
        array_push($isPostMainAttach,false);
      }
      array_push($postAttach2,$row2["attachId"]);
      array_push($postId2,$row2["postId"]);
      array_push($postTitle2,$postTitle[$i]);
    }
  }
  return array($postId2,$postTitle2,$postAttach2,$isPostMainAttach,$postBy);
}
function getPinPost($belong,$type){
  $postId = array();
  $postFileId = array();
  $postTitle = array();
  $postTitle2 = array();
  $mainAttach = array();
  $postAttach2 = array();
  $postId2 = array();
  $isPostMainAttach = array();
  $sql = "select * from `member`.`post` where belong = '".$belong."' and type = '".$type."' and pin = '1'";
  $rt = getDb($sql,4);
  while ($row = $rt->fetch_assoc()) {
    array_push($postId,$row["id"]);
    array_push($postFileId,$row["fileId"]);
    array_push($mainAttach,$row["fileId"]);
    array_push($postTitle,$row["title"]);
  }
  for($i=0;$i<count($postId);$i++){
    $sql = "select * from `member`.`postattach` where postId = '".$postId[$i]."'";
    $rt2 = getDb($sql,4);
    while ($row2 = $rt2->fetch_assoc()){
      if($row2["attachId"]==$postFileId[$i]){
        // echo "<br>ttt".$row2["attachId"].$postFileId[$i];
        array_push($isPostMainAttach,true);
      }else{
        array_push($isPostMainAttach,false);
      }
      array_push($postAttach2,$row2["attachId"]);
      array_push($postId2,$row2["postId"]);
      array_push($postTitle2,$postTitle[$i]);
    }
  }
  return array($postId2,$postTitle2,$postAttach2,$isPostMainAttach);
}
function getUserId(){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $optParams = array(
    'fields' => 'user(permissionId)'
  );
  try {
    $about = $service->about->get($optParams);
    $about = json_encode($about, true);
    $json = json_decode($about, true);
    $id = $json['user']['permissionId'];
    return $id;
  }
  catch(Exception $e) {
    echo "error";
    print "An error occurred: " . $e->getMessage();
  }
}
function getCurrentYear($groupId){
  $sql = "select * from `member`.`group` where groupID='$groupId'";
  $rt = getDb($sql,4);
  $currentYear = "";
  while ($row = $rt->fetch_assoc()) {
    $currentYear = $row["currentYear"];
  }
  return $currentYear;
}
function getWho()
{
  $rt = shell_exec('whoami');
  return $rt;
}
function handOver($groupId,$email,$newYear){
  $currentEmail = getEmail();
  $permissionList = getPermissionList($groupId,$currentEmail);
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $role = checkRole($currentEmail,$groupId);
  
  $service_s = new Google_Service_Sheets($client);
  $range = 'A2:G';
  // 2 & 4
  $values = $service_s->spreadsheets_values->get(getGroupCrewSheet($groupId), $range);
  for($i = 0 ; $i<count($permissionList);$i++){
    if(getUserId() != $permissionList[$i]){
      $service->permissions->delete($groupId, $permissionList[$i]);
    }
  }
  // ^^^^^^^^^
  // 刪舊有權限
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach ($values as $row) {
      $userEmail = $row[2];
      if($userEmail!=$email){
        $userPermission = new Google_Service_Drive_Permission(array(
          'type' => 'user',
          'role' => 'reader',
          'emailAddress' => $userEmail
        ));
        $request = $service->permissions->create($groupId, $userPermission, array(
          'fields' => 'id'
        )); 
      }
    }
    $userPermission = new Google_Service_Drive_Permission(array(
      'type' => 'user',
      'role' => 'owner',
      'transferOwnership' => 'true',
      'emailAddress' => $email
    ));
    $request = $service->permissions->create($groupId, $userPermission, array('fields' => 'id', 'transferOwnership' => 'true'));
  }
  // var_dump($request);
  createFolderPermission($groupId,getGroupCrewSheet($groupId),$newYear);
  createGroupFolderPermissionEditor($groupId);
  createGroupFolderPermission($groupId,"",getGroupCrewSheet($groupId));
  $sql = "update `member`.`group` set currentYear='$newYear' where groupID = '$groupId'";
  insertDb($sql);
}
function ifInFolder($service, $folderId, $fileId)
{
  // echo $folderId;
  // echo "<br/>".$fileId."<br/>";
  $optParams = array(
    'fields' => "name, parents",
  );
  $file_parent = $service->files->get($fileId, $optParams);
  $temp = json_encode($file_parent, true);
  $json = json_decode($temp, true);
  $parent = $json['parents'][0];
  // echo "<br/>".$folderId."end";
  echo "<br/>" . $parent . "-----" . $folderId . "<br/>";
  if ($parent == $folderId) {
    echo $parent;
  }
  else {
    // echo "<br/>Ap".$parent."<br/>";
    // echo "<br/>Bf".$folderId."<br/>";
    // echo "null";
  }
}
function insertDb($sql)
{
  $servername = "localhost";
  $username = "kan";
  $password = "15110215";
  // Create connection
  $conn = new mysqli($servername, $username, $password);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  mysqli_set_charset($conn, "utf8");
  if ($conn->query($sql) === true) {
    // echo "New record created successfully";
  }
  else {
    echo "Error: " . $sql . "<br />" . $conn->error;
  }
  $conn->close();
  // $conn->close();
}
function initCrewSheet($crewsheetId){
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $values = [["time", "name", "email", "phoneNumber", "position", "year", "role"
  // Cell values ...
  ],
  // Additional rows ...
  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A:G';
  $response = $service->spreadsheets_values->append($crewsheetId, $range, $body, $params);
}
function initCrew($groupId){
  $_SESSION['groupId'] = $groupId;
  // getMemberSheet(1);
  initCrew2(getGroupCrewSheet($groupId));
}
function initCrew2($fileId){
  $folderId = $_SESSION['groupId'];
  unset($_SESSION['groupId']);
  $service = new Google_Service_Sheets(getClient(0));
  $currentYear = "105";
  $secondLevelGroupId = "";
  $rootroot = $GLOBALS['rootroot'];
  $spreadsheetId = $fileId;
  $range = 'F2:F';
  $response = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $year = array();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      // judge if repeat
      if (!array_key_exists($row[0], $year)) {
        $temp = "$row[0]";
        array_push($year, "$temp");
      }
    }
    $year = array_unique($year);
    $new_year = array_values($year);
  }
  $notCreateYet = $new_year;
  $service = new Google_Service_Drive(getClient(0));
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$rootroot' in parents and trashed=false";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
  }
  else {
    foreach($results->getFiles() as $file) {
      $gotDir = false;
      // check drive root folder if exist folder with those name
      for ($i = 0; $i < count($new_year); $i++) {
        // if(strcasecmp($position[$i],$file->getName())==0){
        if ($new_year[$i] == $file->getName()) {
          $gotDir = true;
          $gotDirName = $new_year[$i];
          unset($notCreateYet[$i]);
        }
      }
    }
  }
  $firstLevelId = $folderId;
  $notCreateYet = array_values($notCreateYet);
  if (count($notCreateYet) > 0) {
    for ($i = 0; $i < count($notCreateYet); $i++) {
      $folderId = createFolder($notCreateYet[$i], $firstLevelId, false, $spreadsheetId);
      createGroupFolderPermission($firstLevelId, $folderId, $fileId);
      createGroupFolderPermissionEditor($folderId);
      $secondLevelGroupId = createFolder("組別", $folderId, false, $spreadsheetId);
      createFolder("活動", $folderId, false, $spreadsheetId);
    }
  }
  $sql = "update `member`.`group` set crew_sheet_id = '$spreadsheetId' where groupID = '$firstLevelId'";
  insertDb($sql);
  checkPositionFolderExist2($spreadsheetId,$firstLevelId ,$secondLevelGroupId,$currentYear);
}
function initMemberSheet($membersheetId)
{
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $service2 = new Google_Service_Drive($client);
  $values = [["time", "name", "id", "gender", "class", "department", "year", "gmail", "tel", "diet", "skill", "prefer", "rank", "status"
  // Cell values ...
  ],
  // Additional rows ...
  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A:N';
  $response = $service->spreadsheets_values->append($membersheetId, $range, $body, $params);
  $userPermission = new Google_Service_Drive_Permission(array(
    'type' => 'anyone',
    'role' => 'reader'
    // 'emailAddress' => $userEmail
  ));
  $service2->permissions->create($membersheetId, $userPermission, array(
    'fields' => 'id'
  ));
}
function listFolderTree($location)
{
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "'$location' in parents and trashed=false";
  $results = $service->files->listFiles($parameters);
  $list = array();
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  else {
    foreach($results->getFiles() as $file) {
      $type = $file->getMimetype();
      if ($type = 'application/vnd.google-apps.folder') {
        // echo "<br />\n";
        // printf("%s", $file->getName());
        $fileName = $file->getName();
        $fileId = $file->getId();
        // echo '<a href="control.php?act=listFolderTree&pId=' . $fileId . '">' . $fileName . '</a>';
        array_push($list, array(
          $fileName,
          $fileId
        ));
      }
    }
  }
  // return array($fileName,$fileId);
  return $list;
}
function inputYear($fileId,$groupId){
  // echo '
    // <form action = "control.php" method="post">
      // <input type="hidden" name="fileId" value="'.$fileId.'">
      // <input type="text" name="year" value="">
      // <input type="submit" name="act" value="inputYear">
    // </form>
  // ';
  // checkYearFolderExist2($fileId);
  initCrew2($fileId,$groupId);
}
function newApplyGroup($groupName,$email){
  $sql = "insert into `member`.`apply` (applicantEmail,applyGroupName,status) VALUES ('$email','$groupName',0)";
  insertDb($sql);
}
function newGroup($groupName,$email){
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => $groupName,
    'mimeType' => 'application/vnd.google-apps.folder',
    'parents' => array(
      $GLOBALS['rootroot']
    )
  ));
  $results = $service->files->create($fileMetadata, array(
    'fields' => 'id'
  ));
  $driveId = $results->getId();
  $crewsheetId = createFile("sheet", "crewSheet", $driveId);
  $membersheetId = createFile("sheet", "memberSheet", $driveId);
  $userPermission = new Google_Service_Drive_Permission(array(
      'type' => 'user',
      'role' => 'owner',
      'transferOwnership' => 'true',
      'emailAddress' => $email
    ));
    $request = $service->permissions->create($driveId, $userPermission, array('fields' => 'id', 'transferOwnership' => 'true'));
  $sql = "insert into `member`.`group` (groupName,groupID,crew_sheet_id,currentYear,member_sheet_id) VALUES ('$groupName','$driveId','$crewsheetId',105,'$membersheetId')";
  $sql2 = "insert into `member`.`useraccessiblegroup` (email,groupID,year,role) VALUES ('$email','$driveId',105,100)";
  
  initMemberSheet($membersheetId);
  initCrewSheet($crewsheetId);
  insertDb($sql);
  insertDb($sql2);
}
function newMemberDetail($name, $id, $email, $gender, $class, $department, $year, $tel, $diet, $skill, $prefer, $groupId, $status)
{
  $time = date(DATE_RFC2822);
  $sql = "select * from `member`.`group` where groupID= '" . $groupId . "'";
  $rt = getDb($sql, 4);
  $member_sheet_id = "";
  while ($row = mysqli_fetch_row($rt)) {
    $member_sheet_id = $row[5];
  }
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $values = [[$time, $name, $id, $gender, $class, $department, $year, $email, $tel, $diet, $skill, $prefer, 0, $status
  // Cell values ...
  ],
  // Additional rows ...
  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A:N';
  $response = $service->spreadsheets_values->append($member_sheet_id, $range, $body, $params);
}
function newPost($title,$belong,$type,$mime,$newPostAttach,$attach,$postBy){
  echo $postBy;
  $postid = "";
    // 開個屬於帖文內容的doc
  $fileId = createFile($mime,$title,$belong);
  $sql = "insert into `member`.`post` (title,fileId,belong,type,pin,postBy) VALUES ('$title','$fileId','$belong','$type',0,'$postBy')";
  // 找回剛才創建的文件，加入db
  $checkpostid = "select * from `member`.`post` where title = '".$title."' and fileId = '".$fileId."' and belong = '".$belong."' and type = '".$type."'";
  insertDb($sql);
  $rt = getDb($checkpostid,4);
  while ($row = $rt->fetch_assoc()) {
    $postid = $row["id"];
  }
  $sql2 = "insert into `member`.`postattach` (attachId,postId) VALUES ('$fileId','$postid')";
  insertDb($sql2);
  // 寫入新開的文件
  for($x=0;$x<count($newPostAttach);$x++){
    if($newPostAttach != "" && count($newPostAttach) != 0){
      list($newPostAttachTitle,$newPostAttachBelong,$newPostType,$newPostAttachMime)=$newPostAttach[$x];
      if($newPostAttachBelong!="" || $postid != ""){
        $fileId = createFile($newPostAttachMime,$newPostAttachTitle,$newPostAttachBelong);
        $sql3 = "insert into `member`.`postattach` (attachId,postId) VALUES ('$fileId','$postid')";
        insertDb($sql3);
      }
    }
  }
  // 寫入掛載的文件
  for($x=0;$x<count($attach);$x++){
    if($attach != "" && count($attach) != 0){
      list($exsistTitle,$exsistsFileId,$exsistsBelong,$existsPosttype)=$attach[$x];
      $sql3 = "insert into `member`.`postattach` (attachId,postId) VALUES ('$exsistsFileId','$postid')";
      insertDb($sql3);
    }
  }
  unset($_SESSION['attach']);
  unset($_SESSION['newPostAttach']);
  unset($_SESSION['tempTitle']);
  // header('Location: index.php');
}
function newActivity($name,$belong,$belongYear){
  $temp = "[活動幹部]".$name;
  $yearId=getFolderId($belongYear,$belong);
  $actFolder = getFolderId("活動",$yearId);
  $driveId = createFile("folder",$name,$actFolder);
  $crewMemberSheet = createFile("sheet",$temp,$driveId);
  // insert title to actCrewMember
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $values = [["time","name","email","tel","position"]];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A1:F';
  $response = $service->spreadsheets_values->append($crewMemberSheet, $range, $body, $params);
  $sql = "insert into `member`.`activity` (activityName,driveId,belong,belongYear,crewMemberSheet) values ('$name','$driveId','$belong','$belongYear','$crewMemberSheet')";
  insertDb($sql);
  header('Location: index.php');
}
function printMemberSheetValue($member_sheet_id, $role)
{
  $name = array();
  $gender = array();
  $id = array();
  $class = array();
  $department = array();
  $year = array();
  $gmail = array();
  $tel = array();
  $diet = array();
  $skill = array();
  $prefer = array();
  $status = array();
  // $client = getClient(0);
  $client = getClientReadOnly();
  $service = new Google_Service_Sheets($client);
  $range = 'A2:N';
  $response = $service->spreadsheets_values->get($member_sheet_id, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "PrintMemberSheetValue : No data found.\n";
  }
  else {
    foreach($values as $row) {
      array_push($name, $row[1]);
      array_push($id, $row[2]);
      array_push($gender, $row[3]);
      array_push($class, $row[4]);
      array_push($department, $row[5]);
      array_push($year, $row[6]);
      array_push($gmail, $row[7]);
      array_push($tel, $row[8]);
      array_push($diet, $row[9]);
      array_push($skill, $row[10]);
      array_push($prefer, $row[11]);
      array_push($status, $row[13]);
    }
    return array(
      $name,
      $id,
      $gender,
      $class,
      $department,
      $year,
      $gmail,
      $tel,
      $diet,
      $skill,
      $prefer,
      $status
    );
  }
}
function readCrewSheet($actCrewSheet){
  $name = array();
  $email = array();
  $phoneNumber = array();
  $position = array();
  $group = array();
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = "B:E";
  $response = $service->spreadsheets_values->get($actCrewSheet, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "settingGroup : No data found.\n";
  }
  else {
    foreach($values as $row) {
      array_push($name, $row[0]);
      array_push($email, $row[1]);
      array_push($phoneNumber, $row[2]);
      array_push($position, $row[3]);
    }
    return array(
      $name,
      $email,
      $phoneNumber,
      $position
    );
  }
}
function refreshGroupPermission($groupId){
  // only owner can use this
  $email = getEmail();
  $crew_sheet_id = getGroupCrewSheet($groupId);
  $permissionList = getPermissionList($groupId,$email);
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  for($i = 0 ; $i<count($permissionList);$i++){
    if(getUserId() != $permissionList[$i]){
      $service->permissions->delete($groupId, $permissionList[$i]);  
    }
  }
  createFolderPermission($groupId,$crew_sheet_id,"105");
  createGroupFolderPermissionEditor($groupId);
  createGroupFolderPermission($groupId,"",$crew_sheet_id);
}
function refuseApply(){
  $sql = "update `member`.`apply` set status = '-1' where applyGroupName='$groupName'";
  insertDb($sql);
}
function removeMember($no, $sheetId)
{
  $no = $no + 2;
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = 'A' . $no . ':N' . $no;
  $returnValue = "true";
  $valueInputOption = "USER_ENTERED";
  $value = [["1"]];
  $requestBody = new Google_Service_Sheets_ClearValuesRequest();
  $params = ['valueInputOption' => $valueInputOption];
  try {
    $response = $service->spreadsheets_values->clear($sheetId, $range, $requestBody);
  }
  //
  catch(Exception $e) {
    $returnValue = "false";
  }
  return $returnValue;
}
function searchGroup($string)
{
  header('Location: searchResult.php?value=' . $string . '');
}
function selectFirstSheet($fileId, $type)
{
  // echo "this file has been selected";
  // echo "<br/>";
  // echo $fileId;
  if ($type == 0) {
    getMemberList($fileId);
  }
  if ($type == 1) {
    initCrew2($fileId);
    // checkYearFolderExist2($fileId);
  }
  if ($type == 2) {
    return $fileId;
  }
  if ($type == 3) {
    checkPositionFolderExist2($fileId);
  }
}
function settingGroup($groupId)
{
  // echo $groupId;
  $name = array();
  $email = array();
  $phoneNumber = array();
  $position = array();
  $group = array();
  $sheetId = getGroupCrewSheet($groupId);
  $client = getClientReadOnly();
  // var_dump($client);
  $service = new Google_Service_Sheets($client);
  // echo '<pre>', var_export($service, true), '</pre>', "\n";
  $range = "B:F";
  $response = $service->spreadsheets_values->get($sheetId, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "settingGroup : No data found.\n";
  }
  else {
    foreach($values as $row) {
      array_push($name, $row[0]);
      array_push($email, $row[1]);
      array_push($phoneNumber, $row[2]);
      array_push($position, $row[3]);
      array_push($group, $row[4]);
    }
    return array(
      $name,
      $email,
      $phoneNumber,
      $position,
      $group
    );
  }
}
?>