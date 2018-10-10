<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
if(isset($_POST['verCode'])){ //check if form was submitted
  $input = $_POST['verCode']; //get input text
  echo '<h1>'.$input.'</h1>';
}
function logout()
{
    
}
?>