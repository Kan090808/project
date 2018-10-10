<?php
require __DIR__ . '/vendor/autoload.php';

function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->setScopes(Google_Service_Drive::DRIVE);
    $client->setAuthConfig('drive_secret.json');
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = 'token.json';
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

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }

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
// google doc = application/vnd.google-apps.document
// google sheet = application/vnd.google-apps.spreadsheet
// google slide =  application/vnd.google-apps.presentation
// google form = application/vnd.google-apps.form
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
      printf("%s (%s) [%s]\n", $file->getName(), $file->getId(), $file->getMimeType());
    }
  }
  $pid = '1KFFRE62gtj2sdkSXjm17aMChz31-qH4b';
$fileMetadata = new Google_Service_Drive_DriveFile(array(
    'name' => 'Project plan',
    
    'parents' =>  array($pid),
    'mimeType' => 'application/vnd.google-apps.form'));
$file = $service->files->create($fileMetadata, array(
    'fields' => 'id'));
printf("File ID: %s\n", $file->id);

?>