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

<script>
  function FileDetails() {
    $("#num").empty();
    $("#th").empty();
    $("#tb").empty();
    // GET THE FILE INPUT.
    var fi = document.getElementById('file');

    // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
    if (fi.files.length > 0) {
      // THE TOTAL FILE COUNT.
      document.getElementById('num').innerHTML =
        '<b>已選擇: ' + fi.files.length + '個檔案</b></br >';

      // RUN A LOOP TO CHECK EACH SELECTED FILE.
      for (var i = 0; i <= fi.files.length - 1; i++) {

        var fname = fi.files.item(i).name; // THE NAME OF THE FILE.
        var fsize = fi.files.item(i).size; // THE SIZE OF THE FILE.

        // SHOW THE EXTRACTED DETAILS OF THE FILE.
        document.getElementById('tb').innerHTML =
          document.getElementById('tb').innerHTML + '<tr><td> ' +
          fname + '</td><td>' + fsize + 'bytes</td><td>' +
          '<button type="button" class="close" aria-label="close">' +
          '<span aria-hidden="true">&times;</span></button></td></tr>';
      }
    } else {
      $("#num").empty();
      $("#th").empty();
      $("#tb").empty();
    }
  }
</script>
<script>
  $('#join').click(function () {
    $('#mainContent').load('join.php');
  });
  $('#member').click(function () {
    $('#mainContent').load('member.php');
  });
  $('#club').click(function () {
    $('#mainContent').load('club.php');
  });
  $('#calendar').click(function () {
    $('#mainContent').load('calendar.php');
  });
  $('#folder').click(function () {
    $('#mainContent').load('folder.php');
  });
  $('#searchclub').click(function () {
    $('#mainContent').load('searchclub.php');
  });
  $("input[id='checkall']").click(function () {
      $("table .check").prop('checked', $(this).prop('checked'));
  });
  // $("#checkall").click(function(){
  //   $('.check').not(this).prop('checked', this.checked);
  // });
  function searchClub() {
    var input, filter, tb, tr, td, i;
    input = document.getElementById("searchString");
    filter = input.value.toUpperCase();
    tb = document.getElementById("allClub");
    tr = tb.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
  }
</script>
</body>

</html>