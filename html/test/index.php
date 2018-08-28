<?php
require_once __DIR__.'/vendor/autoload.php';
session_start();

$client = new Google_Client();
$client->setAuthConfig('test.json');
$client->addScope(Google_Service_Drive::DRIVE);
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
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
  echo "
        <form method='post' action='control.php'>
          <input type='submit' name = 'act' value='logout'>
        </form>";
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>