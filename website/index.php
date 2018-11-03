<?php
require("../html/model.php");
$_SESSION["status"] = checkLogin();
if ($_SESSION["status"] == "false") {
  $name = "未登入";
} else {
  $name = getName();
  $email = getEmail();
  list($groupName,$groupId)= getJoinedGroup($email);
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