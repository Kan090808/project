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
  $('.folder').click(function () {
    var giveid = this.id;
    var givename = this.name;
    // var givepage = this.page;
    // var givepage = $(a[name=givename]).attr('page');
    var givepage = $('#'+giveid).data('page');
    // alert(giveid);
    $('#mainContent').load('folder.php?id='+giveid+'&name='+givename+'&data-page='+givepage);
    // alert(this.name);
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
  function SubmitFormData() {
    var title = $("#title").val();
    var title2 = $("#title2").val();
    var belong = $("#belong").val();
    // alert(belong);
    var type = $("#type").val();
    var mime = $("#mime").val();
    var newFileMime = $("input[type=radio]:checked").val();
    $.post("../html/control.php?act=newPostAttach", { title,title2,belong,type,mime,newFileMime },
    function() {
      $('#cgAttach').load('post.php #cgAttach');
      $('#createGattach')[0].reset();
      $('#newGattach').modal('hide');
      
    });
    
  }
  function createPost(){
      var title = $('#title').val();
      var belong = $('#belong').val();
      var type = $("#type").val();
      var mime = $("#mime").val();
      var postBy = $("#postBy").val();
      var attach = $('#attach').val();
      var newPostAttach = $('#newPostAttach').val();
      // alert("i am in");
      // alert(title);
      // alert(belong);
      // alert(type);
      // alert(mime);
      // alert(postBy);
      // alert(attach);
      // alert(newPostAttach);
      $.post("../html/control.php?act=newPost", {title,belong,type,mime,postBy,attach,postBy,attach,newPostAttach},
      function() {
        $('#results').load('post.php #results');
        // $('#mainContent').load(location.href+' #mainContent');
        $('#createPost')[0].reset();
        $('#newpost').modal('hide');

      });
      // alert("success");
    }
  // function clearnewpost() {
  //   $.post("../html/control.php?act=clearChoseSession",
  //   function() {
  //     $('#cgAttach').load('post.php #cgAttach');
  //     $('#createGattach')[0].reset();
  //     $('#newpost #formtitle').val("");
  //     $('#newpost #file').val("");
  //   });
  // }
  function clearnewpost(){
    $('#newpost form').get(0).reset();
    // $('#file').val();
    // document.getElementById("file").value = "";
  }  
  function clearnewg(){
    $('#createGattach').get(0).reset();
  }
</script>
</body>

</html>