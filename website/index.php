<?php
error_reporting(E_ERROR | E_PARSE);

require("../html/model.php");
header("Content-Type:text/html; charset=utf-8");
$_SESSION["status"] = checkLogin();
if ($_SESSION["status"] == "false") {
  $name = "未登入";
} else {
  $initEmail = getEmail();
  $name = getName();
  
  list($groupName,$groupId,$currentYear) = getJoinedGroup($initEmail);
  
}
?>
<?php include("header.php"); ?>
<!-- Sidebar chat end-->

<div class="content-wrapper">
  <div class="container" id="mainContent">
  </div>
</div>
<?php include("footer.php");?>

</html>