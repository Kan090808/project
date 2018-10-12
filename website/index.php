<?php
require("../html/model.php");
$_SESSION["status"] = checkLogin();
if ($_SESSION["status"] == "false") {
  $name = "未登入";
} else {
  $name = getEmail();
}
?>
<?php include("header.php"); ?>
<!-- Sidebar chat end-->
<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <!-- Main content starts -->
  <?php 
  if($_SESSION["status"] == "true"){
    include("homepage.php");
  }
  ?>
  <!-- Required Jqurey -->
  <script src="assets/plugins/jquery/dist/jquery.min.js"></script>
  <script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="assets/plugins/tether/dist/js/tether.min.js"></script>

  <!-- Required Fremwork -->
  <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

  <!-- waves effects.js -->
  <script src="assets/plugins/Waves/waves.min.js"></script>

  <!-- Scrollbar JS-->
  <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
  <script src="assets/plugins/jquery.nicescroll/jquery.nicescroll.min.js"></script>

  <!--classic JS-->
  <script src="assets/plugins/classie/classie.js"></script>

  <!-- notification -->
  <script src="assets/plugins/notification/js/bootstrap-growl.min.js"></script>

  <!-- Rickshaw Chart js -->
  <script src="assets/plugins/d3/d3.js"></script>
  <script src="assets/plugins/rickshaw/rickshaw.js"></script>

  <!-- Sparkline charts -->
  <script src="assets/plugins/jquery-sparkline/dist/jquery.sparkline.js"></script>

  <!-- Counter js  -->
  <script src="assets/plugins/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/plugins/countdown/js/jquery.counterup.js"></script>

  <!-- custom js -->
  <script type="text/javascript" src="assets/js/main.min.js"></script>
  <script type="text/javascript" src="assets/pages/dashboard.js"></script>
  <script type="text/javascript" src="assets/pages/elements.js"></script>
  <script src="assets/js/menu.min.js"></script>

  <script>
    var $window = $(window);
    var nav = $('.fixed-button');
    $window.scroll(function () {
      if ($window.scrollTop() >= 200) {
        nav.addClass('active');
      } else {
        nav.removeClass('active');
      }
    });
  </script>
  </body>

  </html>