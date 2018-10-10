<?php
require __DIR__ . '/../vendor/autoload.php';

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
    $client->setAuthConfig('drive_secret.json');
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
function isFileInFolder($service, $folderId, $fileId) {
  $optParams = array(
    'fields' => "name, parents",
  );
  $file_parent = $service->files->get($fileId, $optParams);
  var_dump($file_parent);
  $temp = json_encode($file_parent,true);
  $json = json_decode($temp, true);
  $parent=$json['parents'][0];
  var_dump($json);
  echo "parent id : ".$parent;
  // try {
  //   $service->parents->get($fileId, $folderId);
  // } catch (apiServiceException $e) {
  //   if ($e->getCode() == 404) {
  //     return false;
  //   } else {
  //     print "An error occurred: " . $e->getMessage();
  //     throw $e;
  //   }
  // } catch (Exception $e) {
  //   print "An error occurred: " . $e->getMessage();
  //   throw $e;
  // }
  // return true;
}
function printAbout($service) {
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
}
// get parent id from a file id 
$client = getClient();
$service = new Google_Service_Drive($client);
// printAbout($service);
$folderId = "1lO1NaFst37T_qQ0OyWrcOHt8jGQLbRD8";
$fileId = "1tNrgNOu42U4xAyJg0BvOPw3O8ax84Uwb";
isFileInFolder($service,$folderId,$fileId);
?>
