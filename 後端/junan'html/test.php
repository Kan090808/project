<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function expandHomeDirectory($path)
{
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

function getClientSheet(){
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
    echo "<a href='$authUrl' target='_blank'>Open this link to get verification</a>";
    print '<br />Enter verification code: ';
    echo '
    <html>
      <body>
      <form action="loginControl.php?" method="post">
        <!-- <form action="loginControl.php" method="post"> -->
          verification : <input type="text" name="verCode" value=""><br>
          <input type="submit">
        </form>';
    echo '</body></html> ';
    // $authCode = trim(fgets(STDIN));
    
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}
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
?>