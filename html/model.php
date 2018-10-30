<?php
session_start();
require __DIR__ . '/vendor/autoload.php';

if (isset($_POST['verCode'])) { //check if form was submitted
  $input = $_POST['verCode']; //get input text
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

function approvedMember($no,$sheetId){
  // echo $no.$groupId;
  $no = $no + 2;
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = 'L'.$no;
  $response = $service->spreadsheets_values->get($sheetId, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      echo $row[11];
    }
  } 
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

function checkRole($email,$groupId){
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

  $range = 'A2:L';
  $response = $service->spreadsheets_values->get($member_sheet_id, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      if ($row[5] == $email) {
        $status = $row[11];
        return $status;
      }
      else {
        return "null";
      }
    }
  }
}

function checkYearFolderExist()
{
  getMemberSheet(1);
}

function checkYearFolderExist2($fileId)
{

  // this function is called with a sheet file id
  // get all year by sheet

  $client = getClientSheet();
  $service = new Google_Service_Sheets($client);
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
  $client = getClient(0);
  $service = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "checkYearFolderExist : No files found.\n";
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

  $firstLevelId = createFolder($title, 'root', true, $spreadsheetId);

  // create folder by $notCreateYet array

  $notCreateYet = array_values($notCreateYet);

  // create second level folder

  if (count($notCreateYet) > 0) {
    for ($i = 0; $i < count($notCreateYet); $i++) {

      // echo $notCreateYet[$i];

      $folderId = createFolder($notCreateYet[$i], $firstLevelId, false, $spreadsheetId);

      // echo "------".$folderId;
      // get id of folder you had just create

      createGroupFolderPermission($firstLevelId, $folderId, $fileId);
    }
  }

  checkPositionFolderExist2($spreadsheetId, $firstLevelId);
}

// clear

function checkPositionFolderExist()
{
  getMemberSheet(3);
}

// for position

function checkPositionFolderExist2($fileId, $firstLevelId)
{

  // check each row position's year
  // get all position name by sheet

  $client = getClientSheet();
  $service = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;

  // range only include the position

  $range = 'E2:F';
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
  $judge = array();

  // 先判斷

  for ($i = 0; $i < count($position); $i++) {
    $t = $position[$i] . "+" . $year[$i];
    if (in_array($t, $judge) == false) {
      array_push($judge, $t);
      array_push($notCreateYetPosition, $position[$i]);
      array_push($notCreateYetYear, $year[$i]);
    }
  }

  for ($i = 0; $i < count($notCreateYetPosition); $i++) {
    createFolder($notCreateYetPosition[$i], $notCreateYetYear[$i], false, $spreadsheetId);
  }

  createFolderPermission($firstLevelId, $spreadsheetId);
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
    $membersheetId = createFile("sheet", "memberSheet", $driveId);
    $sql = "insert into `member`.`group` (groupName, groupID, crew_sheet_id,member_sheet_id) 
          VALUES ('$name','$driveId','$spreadsheetId','$membersheetId')";
    insertDb($sql);
    initMemberSheet($membersheetId);
  }

  return $results->getId();
}

function createFolderPermission($parentId, $fileId)
{
  $client = getClient(0);
  $client_s = getClientSheet();
  $service = new Google_Service_Drive($client);
  $service_s = new Google_Service_Sheets($client_s);
  $spreadsheetId = $fileId;

  // echo $spreadsheetId;
  // $spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';

  $range = 'A2:F';

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
      $yId = getFolderId($year, $parentId);
      $poId = getFolderId($position, $yId);
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
      $sqlTest = "insert into `member`.`useraccessiblegroup` (email,groupID,year) values ('$userEmail','$parentId','$year')";
      $sql3 = "select * from `member`.`useraccessiblegroup` where email = '$userEmail' and groupID = '$parentId' and year='$year'";
      $result = getDb($sql3, 4);
      if (mysqli_num_rows($result) == 0) {
        insertDb($sqlTest);
      }

      insertDb($sql);
    }
  }

  // delete the illegal permission id come from inherit
  // $service->permissions->delete($folderId, $permissionId);

}

// createGroupFolderPermission is for create father/group folder permission
// if not create permission on father folder, unable to browser/list child folder
// eventhought you had child folder permission

function createGroupFolderPermission($parentId, $folderId, $sheetId)
{
  $client = getClient(0);
  $client_s = getClientSheet();
  $service = new Google_Service_Drive($client);
  $service_s = new Google_Service_Sheets($client_s);
  $spreadsheetId = $sheetId;
  $range = 'A2:F';

  // 2 & 5 , email and year

  $response = $service_s->spreadsheets_values->get($spreadsheetId, $range);
  $values = $response->getValues();
  $role = 'reader';
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {

      // usermail == 2 , year == 5

      $userEmail = $row[2];
      array_push($position, "$row[5]");

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
  else
  if ($act == "sheet") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.spreadsheet'
    ));
  }
  else
  if ($act == "slide") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.presentation'
    ));
  }
  else
  if ($act == "form") {
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' => array(
        $pid
      ) ,
      'mimeType' => 'application/vnd.google-apps.form'
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

  // if ($client->isAccessTokenExpired()) {
  //   $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
  //   file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  // }

  if ($client->isAccessTokenExpired()) {
    $refreshToken = $client->getRefreshToken();
    $client->refreshToken($refreshToken);
    $newAccessToken = $client->getAccessToken();
    $newAccessToken['refresh_token'] = $refreshToken;
    file_put_contents($credentialsPath, json_encode($newAccessToken));
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
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }

  return $client;
}

function getCurrentYearGroup($groupId, $currentYear)
{
  return getFolderId($currentYear, $groupId);
}

function getDb($sql, $type)
{

  //  echo $sql.$type;

  $servername = "localhost";
  $username = "kan";
  $password = "15110215";
  $conn = new mysqli($servername, $username, $password);
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
  else
  if ($type == 2) {
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
  else

  if ($type == 3) {
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
  else
  if ($type == 4) {
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
    else
    if ($type == 2) {
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
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$folderId' in parents and trashed=false and (name contains '$name')";
  $results = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    return null;
  }

  if (count($results->getFiles()) > 1) {
    print "folder more that 1.\n";
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
      else
      if ($type == 1) {
      }
    }
  }
}

function getMemberSheet($type)

// use to find memberSheet file in drive

{
  echo $type;
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

function getRole($email)
{
  $sql = "select role from `member`.`useraccessiblegroup` where email = '" . $email . "'";
  $rt = getDb($sql, 4);
  while ($row = mysqli_fetch_row($rt)) {
    $role = $row[0];

    // array_push($joinedGroupId,$row[0]);

  }

  return $role;
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

function getWho()
{
  $rt = shell_exec('whoami');
  return $rt;
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
    echo "New record created successfully";
  }
  else {
    echo "Error: " . $sql . "<br />" . $conn->error;
  }

  $conn->close();

  // $conn->close();

}

function initMemberSheet($membersheetId)
{
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $values = [["time", "name", "gender", "class", "year", "gmail", "tel", "diet", "skill", "prefer", "rank", "status"

  // Cell values ...

  ],

  // Additional rows ...

  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A:L';
  $response = $service->spreadsheets_values->append($membersheetId, $range, $body, $params);
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

function newMemberDetail($name,$email,$gender,$class,$year,$tel,$diet,$skill,$prefer,$groupId,$status){
  $time = date(DATE_RFC2822);
  $sql = "select * from `member`.`group` where groupID= '" . $groupId . "'";
  $rt = getDb($sql,4);
  $member_sheet_id = "";
  while ($row = mysqli_fetch_row($rt)) {
    $member_sheet_id = $row[5];
  }
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $values = [[$time, $name,$gender,$class,$year,$email,$tel,$diet,$skill,$prefer,0,$status

  // Cell values ...

  ],

  // Additional rows ...

  ];
  $body = new Google_Service_Sheets_ValueRange(['values' => $values]);
  $params = ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS'];
  $range = 'A:L';
  $response = $service->spreadsheets_values->append($member_sheet_id, $range, $body, $params);
}

function printMemberSheetValue($member_sheet_id,$role){
  $name = array();
  $gender = array();
  $class = array();
  $year = array();
  $gmail = array();
  $tel = array();
  $diet = array();
  $skill = array();
  $prefer = array();
  $status = array();
  
  $client = getClient(0);
  $service = new Google_Service_Sheets($client);
  $range = 'A2:L';
  $response = $service->spreadsheets_values->get($member_sheet_id, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
  }
  else {
    foreach($values as $row) {
      array_push($name,$row[1]);
      array_push($gender,$row[2]);
      array_push($class,$row[3]);
      array_push($year,$row[4]);
      array_push($gmail,$row[5]);
      array_push($tel,$row[6]);
      array_push($diet,$row[7]);
      array_push($skill,$row[8]);
      array_push($prefer,$row[9]);
      array_push($status,$row[11]);
    }
    return array($name,$gender,$class,$year,$gmail,$tel,$diet,$skill,$prefer,$status);
  }
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
    checkYearFolderExist2($fileId);
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
  $client = getClientSheet();
  $service = new Google_Service_Sheets($client);
  $range = "B:F";
  $response = $service->spreadsheets_values->get($sheetId, $range);
  $values = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
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