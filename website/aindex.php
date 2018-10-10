<?php include("aheader.php"); ?>
<!-- Sidebar chat end-->
<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <!-- Main content starts -->
  <div class="container">
    <div class="row">
      <div class="main-header ">
        <b style="font-size:80px">社團管理平台</b>
      </div>
    </div>
    <div class="row" style="margin-top:25px">
      <ul class="col-sm-4 nav nav-tabs tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#post" role="tab" aria-expanded="true">平台理念</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#drive" role="tab" aria-expanded="true">技術</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="tab" href="#drive" role="tab" aria-expanded="true">如何使用</a>
        </li>
      </ul>
      <div class="tab-content tabs">
        <div class="tab-pane active" id="post" role="tabpanel">
          <?php include("post.php"); ?>
        </div>
        <div class="tab-pane" id="drive" role="tabpanel">
          <?php include("drive.php"); ?>
        </div>
      </div>
    </div>
  </div>
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