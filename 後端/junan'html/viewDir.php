<?php
require("model.php");
$firstTime = true;
session_start();
$location = $_REQUEST['pId'];
if($firstTime = true){
    echo getFolderList($location);
    $firstTime = false;
}else{
    $location = $_REQUEST['pId'];
    echo getFolderList($location);
}
?>