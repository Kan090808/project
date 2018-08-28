<?php
require __DIR__ . '/vendor/autoload.php';
function getClientSheet()
{
  $client = new Google_Client();
  $client->setApplicationName('Google Sheets API PHP Quickstart');
  $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
  $client->setAuthConfig('sheet_client_secret.json');
  $client->setAccessType('offline');
  
  // Load previously authorized credentials from a file.
  $credentialsPath = 'tokenSheet.json';
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));
    
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    
    // Store the credentials to disk.
    if (!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);
  
  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

function getClient()
{
  $client = new Google_Client();
  $client->setApplicationName('project108 ');
  $client->addScope("https://www.googleapis.com/auth/drive");
  $client->setAuthConfig('client_secret.json');
  $client->setAccessType('offline');
  
  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory('tokenA.json');
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));
    
    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
    
    // Store the credentials to disk.
    if (!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);
  
  // Refresh the token if it's expired.
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
  
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      echo "<br />\n";
      printf("%s (%s) [%s]", $file->getName(), $file->getId(), $file->getMimeType());
    }
  }
}

function getFolderList()
{
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      if ($file->getMimeType() == "application/vnd.google-apps.folder") {
        echo "<br />\n";
        printf("%s (%s) [%s]", $file->getName(), $file->getId(), $file->getMimeType());
      }
    }
  }
}

function getMemberSheet()
// use to find memberSheet file in drive
{
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.spreadsheet' and 'root' in parents and trashed=false and (name contains 'member input')";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  if (count($results->getFiles()) > 1) {
    print "member sheet more that 1.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      return $file->getId();
    }
  }
}

function getFolderId($name)
{
  $client          = getClient();
  $service         = new Google_Service_Drive($client);
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false and (name contains '$name')";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
  }
  if (count($results->getFiles()) > 1) {
    print "member sheet more that 1.\n";
  } else {
    foreach ($results->getFiles() as $file) {
      return $file->getId();
    }
  }
}

function getMemberList($type)
{
  $client        = getClientSheet();
  $service       = new Google_Service_Sheets($client);
  $spreadsheetId = getMemberSheet();
  // echo $spreadsheetId;
  //$spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
  $range         = 'A2:E';
  $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      if ($type == 0) {
        echo "<br />\n";
        // name and position
        printf("%s, %s", $row[1], $row[4]);
      } else if($type == 1){

      }
    }
  }
}

function checkFolderExist()
{
  // get all position name by sheet
  $client        = getClientSheet();
  $service       = new Google_Service_Sheets($client);
  $spreadsheetId = getMemberSheet();
  $range         = 'E2:E';
  $response      = $service->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  $position      = array();
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      if (!array_key_exists($row[0], $position)) {
        array_push($position, "$row[0]");
      }
    }
    $position     = array_unique($position);
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
  $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and 'root' in parents and trashed=false";
  $results         = $service->files->listFiles($parameters);
  if (count($results->getFiles()) == 0) {
    print "No files found.\n";
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
      // echo $notCreateYet[$i];
      createFolder($notCreateYet[$i]);
    }
  }
}

function createFolder($name)
{
  $client       = getClient();
  $service      = new Google_Service_Drive($client);
  $fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => $name,
    'mimeType' => 'application/vnd.google-apps.folder'
  ));
  $results      = $service->files->create($fileMetadata, array(
    'fields' => 'id'
  ));
  echo "those folder has created";
  echo "<br />";
  echo $results->getId();
  // createPermission($results->getId,$mail);
}
// notice : different between update and create permission
  $client        = getClient();
  $client_s      = getClientSheet();
  $service       = new Google_Service_Drive($client);
  $service_s     = new Google_Service_Sheets($client_s);
  $spreadsheetId = getMemberSheet();
  // echo $spreadsheetId;
  //$spreadsheetId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
  $range         = 'A2:E';
  // 2 & 4
  $response      = $service_s->spreadsheets_values->get($spreadsheetId, $range);
  $values        = $response->getValues();
  $role          = 'writer';
  if (empty($values)) {
    print "No data found.\n";
  } else {
    foreach ($values as $row) {
      $userEmail      = $row[2];
      echo $userEmail;
      echo $row[4];
      $fileId         = getFolderId($row[4]);
      echo $fileId;
      $userPermission = new Google_Service_Drive_Permission(array(
        'type' => 'user',
        'role' => $role,
        'emailAddress' => $userEmail
      ));
      
      $request = $service->permissions->create($fileId, $userPermission, array(
        'fields' => 'id'
      ));
    }
  }

function getWho()
{
  $rt = shell_exec('whoami');
  return $rt;
}
?> 