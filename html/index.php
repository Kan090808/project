<?php
require("model.php");
$status = checkLogin();
if($status=="false"){
    echo "Login First, please";
    echo "<br />";
    echo "jump to login page in 5 second";
    sleep(5);
    getClient();
}else if($status == "true"){
    
    header('Location: controlMenu.php');
}
?>