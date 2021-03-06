<?php
require_once __DIR__.'/vendor/autoload.php';
// https://accounts.google.com/logout
session_start();

$client = new Google_Client();
$client->setAuthConfigFile('webClient.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
// $client->addScope(Google_Service_Drive::DRIVE);
$client->addScope("https://www.googleapis.com/auth/drive");

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>