<?php
require __DIR__ . '/vendor/autoload.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
    $client = new Google_Client();
    $client->setApplicationName('Google Drive API PHP Quickstart');
    $client->addScope("https://www.googleapis.com/auth/drive");
    $client->setAuthConfig('client_secret.json');
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = 'tokenA.json';
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
// get parent id from a file id 
$client = getClient();
$service = new Google_Service_Drive($client);
$fileId = '1jRQ1jr6DlxAv8VbM5z-NopMTcB0DpT1oqHVzM4BYC1o';
// $optParams = array(
//     'pageSize' => 100,
//     'fields' => 'nextPageToken, files(id, name, mimeType)'
//   );
//   $results   = $service->files->listFiles($optParams);

//   if (count($results->getFiles()) == 0) {
//     print "No files found.\n";
//   } else {
//     foreach ($results->getFiles() as $file) {
//       echo "<br />\n";
//       printf("%s (%s) [%s]", $file->getName(), $file->getId(), $file->getMimeType());
//     }
//   }
$parents = $service->parents->listParents($fileId);
foreach ($parents->getItems() as $parent) {
    print 'File Id: ' . $parent->getId();
}
?>
