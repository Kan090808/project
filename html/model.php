<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
if(isset($_POST['verCode'])){ //check if form was submitted
  $input = $_POST['verCode']; //get input text
  echo '<h1>'.$input.'</h1>';

}
function getGroupShared($folderId){
  // folderId is "104" id
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  // $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$folderId' in parents and trashed=false ";
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and sharedWithMe and trashed=false ";
  $results         = $service->files->listFiles($parameters);
  $allSharedFileId = array();
  $allSharedFileName = array();
  // now you get alot of file that in your sharedWithMe
  // filter them with their parent id, if their parent id is "104" folder id
  // then this is the file that you want
  if (count($results->getFiles()) == 0) {
    print "getShared : No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        array_push($allSharedFileId,$file->getId());
      }
    }
    // now you get a array with all sharedFileID , $allSharedFileId
    // echo "<br/>".count($allSharedFileId)."<br/>";
    for($i=0;$i<count($allSharedFileId);$i++){
      $eachSharedId = $allSharedFileId[$i];
      // echo $folderId;
      // echo "<br/>".$i."-----".$eachSharedId."<br/>";
      // both value is ok
      ifInFolder($service,$folderId,$eachSharedId);
    }
  }

}
function ifInFolder($service,$folderId,$fileId){
  // echo $folderId;
  // echo "<br/>".$fileId."<br/>";
  $optParams = array(
    'fields' => "name, parents",
  );
  $file_parent = $service->files->get($fileId, $optParams);
  $temp = json_encode($file_parent,true);
  $json = json_decode($temp, true);
  $parent=$json['parents'][0];
  // echo "<br/>".$folderId."end";
  echo "<br/>".$parent."-----".$folderId."<br/>";
  if($parent == $folderId){
    echo $parent;
  }else{
    // echo "<br/>Ap".$parent."<br/>";
    // echo "<br/>Bf".$folderId."<br/>";
    // echo "null";
  }
}
function getJoinedGroup(){
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $optParams = array(
    'fields' => 'user(emailAddress)'
  );
  try {
    $about = $service->about->get($optParams);
    $about = json_encode($about,true);
    $json = json_decode($about, true);
    $email=$json['user']['emailAddress'];
    echo $email;
  } catch (Exception $e) {
      echo "error";
    print "An error occurred: " . $e->getMessage();
  }
  $sql = "Select * from `member`.`userAccessibleGroup` where email='$email'; ";
  $accessible = array();
  $accessible=getDb($sql,1);
  for($i=0;$i<count($accessible);$i++){
    $value = $accessible[$i];
    $sql2 = "select * from `member`.`group` where groupID='$value'";
    getDb($sql2,2);
  }
  // $sql2 = "select * from `member`.`group` where groupID in '$accessible'";
  // getDb($sql2,2);
}
function getDb($sql,$type){
 //  echo $sql.$type;
  $servername = "localhost";
  $username = "root";
  $password = "00000000";
  $conn = new mysqli($servername, $username, $password);
  $temp=array();
  $result = $conn->query($sql);
  // $test = $result->fetch_assoc();
  // var_export($test);
  if($type==1){
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        // echo "<br>"."accessible groupID: " . $row["groupID"];
        array_push($temp,$row["groupID"]);
      }
      return $temp;
      reset($temp);
    } else {
      echo "0 results";
    }
  }else if($type==2){
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "<br>"."in group: " . $row["groupName"];
        $gID= $row["groupID"];
        // instead of : direct user to folder by gid
        // show folder list to user by gid
        echo "
          <form method='post' action='control.php'>
            <input type='hidden' name='act' value='getFolderList'>
            <input type='hidden' name='pId' value='$gID'>
            <input type='hidden' name='type' value='2'>
            <input type='submit' value = 'go to your god damn group shared folder'>
          </form>";
        // array_push($temp,$row["groupID"]);
      }
    } else {
      echo "0 results";
    }
  }
  $conn->close();
}
function insertDb($sql){
  $servername = "localhost";
  $username = "root";
  $password = "00000000";

  // Create connection
  $conn = new mysqli($servername, $username, $password);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
  $conn->close();
  // $conn->close();
}

function getClientSheet(){
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->setAuthConfig('webClient.json');
  $client->addScope("https://www.googleapis.com/auth/spreadsheet");
  $client->setAccessType('offline');

  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  } else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '.nip.io/oauth2callback.php';
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}
function checkLogin(){
  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    return "true";
  }else{
    return "false";
  }
}
function getClient(){
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->setAuthConfig('webClient.json');
  $client->addScope("https://www.googleapis.com/auth/drive");
  $client->setAccessType('offline');

  if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
  } else {
    if($_SERVER['HTTP_HOST']=="163.22.17.92"){
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '.nip.io/oauth2callback.php';
    }else{
      $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
    }
      header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  }
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

function expandHomeDirectory($path)
{
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

function getList()
{
  $client  = getClient();
  $service = new Google_Service_Drive($client);

  $optParams = array(
    'pageSize' => 100,
    'fields' => 'nextPageToken, files(id, name, mimeType)'
  );
  $results   = $service->files->listFiles($optParams);
  // $about = $service->about->get();
  // echo $about->getName();
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      echo "<br />\n";
      printf("%s (%s) [%s]", $file->getName(), $file->getId(), $file->getMimeType());
    }
  }
}

function selectFirstSheet($fileId,$type){
  // echo "this file has been selected";
  // echo "<br/>";
  // echo $fileId;
  if($type==0){
    getMemberList($fileId);  
  }
  if($type == 1){
    checkYearFolderExist2($fileId);  
  }
  if($type == 2){
    return $fileId;
  }
  if($type == 3){
    checkPositionFolderExist2($fileId);
  }
}

function getListInDir($location,$type){
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType!='application/vnd.google-apps.folder' and '$location' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
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

function getParent($service,$fileId){
  $optParams = array(
    'fields' => "name, parents",
  );
  $file_parent = $service->files->get($fileId, $optParams);
  // var_dump($file_parent);
  $temp = json_encode($file_parent,true);
  $json = json_decode($temp, true);
  $parent=$json['parents'][0];
  // var_dump($json);
  // echo "parent id : ".$parent;
  return $parent;
}

function getFolderList($location,$type)
{
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "'$location' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "getFolderList : No files found.\n";
  } else {
    // $preLoc = "root";
    $preLoc = getParent($service,$location);
    echo "
    <form method='post' action='control.php'>
      <input type='hidden' name='act' value='getFolderList'>
      <input type='hidden' name='pId' value='$preLoc'>
      <input type='submit' value = 'back to previous'>
    </form>";
    foreach ($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        echo "<br />\n";
        printf("%s ", $file->getName());
        // 1jvBKzL5xKPXhCapPhfdPWes0pPr6MWFT
        $fileId = $file->getId();
        echo "
        <form method='post' action='control.php'>
          <input type='hidden' name='act' value='getFolderList'>
          <input type='hidden' name='pId' value='$fileId'>
          <input type='hidden' name='type' value='$type'>
          <input type='submit' value = 'go to this folder'>
        </form>
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
    echo getListInDir($location,$type);
  }
}

function getMemberSheet($type)
// use to find memberSheet file in drive
{
  echo $type;
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.spreadsheet' and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }else {
    foreach ($results->getFiles() as $file) {
      echo $file->getName();
      echo "<br/>";
      echo $file->getId();
      $fileId=$file->getId();
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

function getFolderId($name,$folderId)
{
  echo "<br />";
  echo $name;
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$folderId' in parents and trashed=false and (name contains '$name')";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "getFolderId : No files found.";
    echo $folderId;
    print "\n";
  }
  if (count($results->getFiles()) > 1) {
    print "folder more that 1.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      return $file->getId();
    }
  }
}

function getMemberList($fileId)
{
  // ok
  $client        = getClientSheet();
  // ok
  $service       = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;
  // echo $spreadsheetId;
  // ok
  //$spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
  $range         = 'A2:F';
  $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      if ($type == 0) {
        echo "<br />\n";
        // name and position
        printf("%s, %s, %s", $row[1], $row[4],$row[5]);
      } else if($type == 1){

      }
    }
  }
}

function checkYearFolderExist(){
  getMemberSheet(1);
}
function checkYearFolderExist2($fileId)
{
  // get all year by sheet
  $client        = getClientSheet();
  $service       = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;
  // range only include the position
  $range         = 'F2:F';
  $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  $year          = array();
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      // judge if repeat
      if (!array_key_exists($row[0], $year)) {
        $temp = "[project]"."$row[0]";
        array_push($year, "$temp");
      }
    }
    $year     = array_unique($year);
    $new_year = array_values($year);
    echo "<br />";
    var_dump($new_year);
    echo "<br />";

  }
  // now had year data in $position
  $notCreateYet    = $new_year;
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "checkYearFolderExist : No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      $gotDir = false;
      // check drive root folder if exist folder with those name
      for ($i = 0; $i < count($new_year); $i++) {
        // if(strcasecmp($position[$i],$file->getName())==0){
        if ($new_year[$i] == $file->getName()) {
          $gotDir     = true;
          $gotDirName = $new_year[$i];
          unset($notCreateYet[$i]);
        }
      }
    }
    // var_dump($notCreateYet);
  }
  // create folder by $notCreateYet array
  $notCreateYet = array_values($notCreateYet);
  // var_dump($notCreateYet);
  if (count($notCreateYet) > 0) {
    for ($i = 0; $i < count($notCreateYet); $i++) {
      // echo $notCreateYet[$i];
      createFolder($notCreateYet[$i],'root',true);
    }
  }
}

function checkPositionFolderExist(){
  getMemberSheet(3);
}
// for position
function checkPositionFolderExist2($fileId)
{
  // check each row position's year

  // get all position name by sheet
  $client        = getClientSheet();
  $service       = new Google_Service_Sheets($client);
  $spreadsheetId = $fileId;
  // range only include the position
  $range         = 'E2:F';
  $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  $position      = array();
  $parent;
  if (empty($values)) {
    print "No data found.\n";
  } else {
    // problem here : how to get parent folder
    // name,folderid;
    foreach ($values as $row) {
      // row[1] == year
      // [project]104
      $parent= "[project]".$row[1];
      // get [project]104 fileID
      $yearId = getFolderId($parent,'root');
      // multiple job in one cell
      if(strpos($row[0], ',') == true){
        $se = explode(", ", $row[0]);
        for($i=0;$i<count($se);$i++){
          if (!array_key_exists($se[$i], $position)) {
            $temp = "[project]"."$se[$i]";
            array_push($position, "$temp");
          }
        }
      }else{
        // judge if repeat
        if (!array_key_exists($row[0], $position)) {
          $temp = "[project]"."$row[0]";
          array_push($position, "$temp");
        }
      }
    }
    // remove repeat value
    $position     = array_unique($position);
    // re-assign key
    $new_position = array_values($position);
    // print_r($position);

    echo "<br />";
    var_dump($new_position);
    echo "<br />";

  }
  // now had position data in $position
  $notCreateYet    = $new_position;
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  // parendId in here should not be root, should be "104"folrderID
  // this para is used for get list of folder in "104"
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and '$yearId' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "checkPositionFolderExist : No create yet.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      $gotDir = false;
      // check drive root folder if exist folder with those name
      for ($i = 0; $i < count($new_position); $i++) {
        // if(strcasecmp($position[$i],$file->getName())==0){
        if ($new_position[$i] == $file->getName()) {
          $gotDir     = true;
          $gotDirName = $new_position[$i];
          unset($notCreateYet[$i]);
        }
      }
    }
    // var_dump($notCreateYet);
  }
  // create folder by $notCreateYet array
  $notCreateYet = array_values($notCreateYet);
  // var_dump($notCreateYet);
  if (count($notCreateYet) > 0) {
    for ($i = 0; $i < count($notCreateYet); $i++) {
      // echo $notCreateYet [$i];
      createFolder($notCreateYet[$i],$yearId,false);
    }
    createFolderPermission($yearId,$fileId);
  }
}

function createFolder($name,$folderId,$isOnRoot)
{
  $client       = getClient();
  $service      = new Google_Service_Drive($client);
  $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => $name,
    'mimeType' => 'application/vnd.google-apps.folder',
    'parents' => array($folderId)
  ));
  $results      = $service->files->create($fileMetadata, array(
    'fields' => 'id'
  ));
  echo "<br />";
  echo "those folder has created";
  echo "<br />";
  echo $results->getId();
  $driveId = $results->getId();
  if($isOnRoot==true){
    $sql="insert into `member`.`group` (groupName, groupID, drive_folder_id) 
          VALUES ('$name','$driveId','$driveId')";
    insertDb($sql);
  }
  // if ($dbClient->query($sql) === TRUE) {
  //   echo "New record created successfully";
  // } else {
  //     echo "Error: " . $sql . "<br>" . $conn->error;
  // }
  // $dbClient->close();
  // little bug : this functino is call by one time, but createPer is run all folder
  // so return error
  // createFolderPermission($folderId);
}
// notice : different between update and create permission
function createFolderPermission($parentId,$fileId)
{
  echo "parent id :";
  echo $parentId;
  $client        = getClient();
  $client_s      = getClientSheet();
  $service       = new Google_Service_Drive($client);
  $service_s     = new Google_Service_Sheets($client_s);
  $spreadsheetId = $fileId;
  // echo $spreadsheetId;
  //$spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
  $range         = 'A2:F';
  // 2 & 4
  $response      = $service_s->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  $role          = 'writer';
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      // usermail == 2 , position == 4
      $userEmail      = $row[2];
      if(strpos($row[4], ',') == true){
        $se = explode(", ", $row[4]);
        for($i=0;$i<count($se);$i++){
          if (!array_key_exists($se[$i], $position)) {
            array_push($position, $se[$i]);
            echo "<br />";
            echo "START to get folder ID";
            echo "<br />";
            $fileId         = getFolderId($se[$i],$parentId);
            $userPermission = new Google_Service_Drive_Permission(array(
              'type' => 'user',
              'role' => $role,
              'emailAddress' => $userEmail
            ));

            $request = $service->permissions->create($fileId, $userPermission, array(
              'fields' => 'id'
            ));
            // INSERT INTO `member`.`user` (email)
            // SELECT * FROM (SELECT '$email') AS tmp
            // WHERE NOT EXISTS (
            //     SELECT email FROM `member`.`user` WHERE email = '$email'
            // );
            $sql="insert into `member`.`user` (email) 
                  Select * from (select '$userEmail') AS tmp
                  where not exists(select email from `member`.`user` where email = '$userEmail')";
            $sql2="insert into `member`.`userAccessibleGroup` (email,groudID) 
                  Select * from (select '$userEmail','$parentId') AS tmp2
                  where not exists(select email from `member`.`userAccessibleGroup` where email = '$userEmail')";
            insertDb($sql);
            insertDb($sql2);
          }
        }
      }else{
        // judge if repeat
        if (!array_key_exists($row[4], $position)) {
          array_push($position, "$row[4]");
          $fileId         = getFolderId($row[4],$parentId);
          $userPermission = new Google_Service_Drive_Permission(array(
            'type' => 'user',
            'role' => $role,
            'emailAddress' => $userEmail
          ));

          $request = $service->permissions->create($fileId, $userPermission, array(
            'fields' => 'id'
          ));
          $sql="insert into `member`.`user` (email) 
                Select * from (select '$userEmail') AS tmp
                where not exists(select email from `member`.`user` where email = '$userEmail')";
          $sql2="insert into `member`.`userAccessibleGroup` (email,groupID) 
                Select * from (select '$userEmail','$parentId') AS tmp2
                where not exists(select email from `member`.`userAccessibleGroup` where email = '$userEmail')";
          insertDb($sql);
          insertDb($sql2);
        }
      }
    }
  }
}
function createFile($act,$newFileName,$pid){
  $client = getClient();
  $service = new Google_Service_Drive($client);
  // $pid = '1KFFRE62gtj2sdkSXjm17aMChz31-qH4b';
  if($act=="doc"){
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' =>  array($pid),
      'mimeType' => 'application/vnd.google-apps.document'));
  }else if($act=="sheet"){
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' =>  array($pid),
      'mimeType' => 'application/vnd.google-apps.spreadsheet'));
  }else if($act=="slide"){
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' =>  array($pid),
      'mimeType' => 'application/vnd.google-apps.presentation'));
  }else if($act=="form"){
    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => $newFileName,
      'parents' =>  array($pid),
      'mimeType' => 'application/vnd.google-apps.form'));
  }else{
    return "error";
  }
  if(isset($fileMetadata)){
    $file = $service->files->create($fileMetadata, array(
        'fields' => 'id'));
    printf("File ID: %s\n", $file->id);
  }

}

function getShared(){
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and trashed=false and sharedWithMe and (name contains '[project]')";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "getShared : No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        echo "<br />\n";
        printf("%s (%s) [%s]", $file->getName(), $file->getId(), $file->getMimeType());
      }
    }
  }
}

function appendData(){
  getMemberSheet(2);
}

function appendData2($name,$email,$phone,$position,$year,$fileId){
  $client = getClient();
  $service = new Google_Service_Sheets($client);
  // DATE_RFC28222
  $time = date(DATE_RFC2822);
  $spreadsheetId = $fileId;
  $values = [
      [
          $time,
          $name,
          $email,
          $phone,  
          $position,
          $year
          // Cell values ...
      ],
      // Additional rows ...
  ];
  $body = new Google_Service_Sheets_ValueRange([
      'values' => $values
  ]);
  $params = [
      'valueInputOption' => 'RAW',
      'insertDataOption' => 'INSERT_ROWS'
  ];

  $range = 'A2:F';
  $response = $service->spreadsheets_values->append($spreadsheetId, $range, $body,$params);
}

function getWho()
{
  $rt = shell_exec('whoami');
  return $rt;
}
?>
