<?php
require('model.php');
$action =$_REQUEST['act'];
switch ($action) {
case 'logout':
  logout();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  break;
}
?>