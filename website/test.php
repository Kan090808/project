<?php $v="200px"?>
<!DOCTYPE html>
<html>

<head>
  <title>Get File Details</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  
</head>

<body style="font:15px Calibri;">
  <!--ADD INPUT OF TYPE FILE WITH THE MULTIPLE OPTION-->
  <p>
    <input type="file" id="file" onchange="FileDetails()" multiple />
  </p>
  <input type="checkbox" class="check">
  <!--SHOW RESULT HERE-->
  <p id="num"></p>
  <table>
    <thead>
      <tr>
        <th>file name</th>
        <th>file size</th>
      </tr>
    </thead>
    <tbody id="fp">

    </tbody>
  </table>
  <!-- <p>
    <input type="submit" value="Show Details" onclick="FileDetails()">
  </p> -->
  <input type="text" id="searchString" onkeyup="searchClub()">
  <table id="allClub">
    <tr><td class="clubName">abc</td></tr>
    <tr><td class="clubName">acd</td></tr>
    <tr><td class="clubName">add</td></tr>
    <tr><td class="clubName">abcde</td></tr>
    <tr><td class="clubName">aefg</td></tr>
  </table>
  <ul>
    <li><a class="giveu"value="test" name="giveu">giveyou</a></li>
    <li><a class="giveu"value="test" name="giveme">giveme</a></li>
  </ul>
  <button id="calendar">press</button>
  <a>hello2</a>
  <thead>
    <tr>
      <th><input type="checkbox" id="checkall" class="check"></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" class="check"></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="check"></td>
    </tr>
    <tr>
      <td><input type="checkbox" class="check"></td>
    </tr>
  </tbody>
  <div class="container" style="margin:0 auto">
    <div class="table-responsive">
      <table class="table table-striped" style="width:100%;">
        <thead>
          <tr>
            <th><input type="checkbox" id="checkall" class="check"></th>
            <th>姓名</th>
            <th>性別</th>
            <th>系所</th>
            <th>班別</th>
            <th>年級</th>
            <th>Gmail</th>
            <th>聯絡號碼</th>
            <th>技術</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="checkbox" class="check"></td>
            <td>簡靖騰</td>
            <td>男</td>
            <td>資管</td>
            <td>大學部</td>
            <td>4</td>
            <td>kanjingterng@gmail.com</td>
            <td>0905620013</td>
            <td>美術</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="check"></td>
            <td>簡靖騰</td>
            <td>男</td>
            <td>資管</td>
            <td>大學部</td>
            <td>4</td>
            <td>kanjingterng@gmail.com</td>
            <td>0905620013</td>
            <td>美術</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="check"></td>
            <td>簡靖騰</td>
            <td>男</td>
            <td>資管</td>
            <td>大學部</td>
            <td>4</td>
            <td>kanjingterng@gmail.com</td>
            <td>0905620013</td>
            <td>美術</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="check"></td>
            <td>簡靖騰</td>
            <td>男</td>
            <td>資管</td>
            <td>大學部</td>
            <td>4</td>
            <td>kanjingterng@gmail.com</td>
            <td>0905620013</td>
            <td>美術</td>
          </tr>
          <tr>
            <td><input type="checkbox" class="check"></td>
            <td>簡靖騰</td>
            <td>男</td>
            <td>資管</td>
            <td>大學部</td>
            <td>4</td>
            <td>kanjingterng@gmail.com</td>
            <td>0905620013</td>
            <td>美術</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <ul>
    <li>hello</li>
    <li>
      <ul>
        <li id="press">heheh</li>
      </ul>
    </li>
  </ul>
  <input type="number">
  <div id="divToReload">
  </div>
  <iframe id="iframe" frameborder="5" width="100%" height="500px">
  </iframe>
</body>
<!-- <script>
  $("file").change(function () {
    FileDetails();
      })
</script> -->
<script>
  
  function FileDetails() {

    // GET THE FILE INPUT.
    var fi = document.getElementById('file');

    // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
    if (fi.files.length > 0) {

      // THE TOTAL FILE COUNT.
      document.getElementById('num').innerHTML =
        '<b>file num: ' + fi.files.length + '</b></br >';

      // RUN A LOOP TO CHECK EACH SELECTED FILE.
      for (var i = 0; i <= fi.files.length - 1; i++) {

        var fname = fi.files.item(i).name; // THE NAME OF THE FILE.
        var fsize = fi.files.item(i).size; // THE SIZE OF THE FILE.

        // SHOW THE EXTRACTED DETAILS OF THE FILE.
        document.getElementById('fp').innerHTML =
          document.getElementById('fp').innerHTML + '<tr><td> ' +
          fname + '<td>' + fsize + 'bytes</td></tr>';
      }
    } else {
      alert('Please select a file.')
    }
  }
</script>
<script>
  // $("#press").click(function() {
  //   //$("#divToReload" ).load( "localhost/website/member.php");
  //   alert("success");
  // });
  // function pls(){

  $('#press').click(function () {

    var url = 'member.php';
    alert(event.target.id);
    $('#divToReload').load('member.php');

  });
  // $('#calendar').click(function () {

  //   // var url = 'member.php';
  //   // alert(event.target.id);
  //   $('#iframe').attr('src', 'https://hackmd.io/IN2EwIUoS1G33PnDK9Iy1A?both');
  // });
  // }
    $("input[id='checkall']").click(function () {
      $(".check").prop('checked', $(this).prop('checked'));
  });
  // $(document).ready(function () {
  //   $('input[id="checkall"]').on('click', function () {
  //     $(this).closest('table').find('tbody :checkbox')
  //       .prop('checked', this.checked)
  //       .closest('tr').toggleClass('selected', this.checked);
  //   });
  // $("input[id='checkall']").click(function () {
  //   $('.check').not(this).prop('checked', this.checked);
  // });
  // $('input[id="checkall"]').change(function() {
  //     $(this).closest('tbody').next().find('.check').prop('checked', this.checked);
  // });
  // $('input[id="checkall"]').change(function() {
  //     var checkthis = $(this);
  //     var checkboxes = $(checkthis).closest('tbody').next().find('.check');
  //     checkboxes.prop("checked", checkthis.checked);
  //   });
  $(".giveu").click(function() {
    var giveval = this.name;
    alert(this.name);
  })
</script>
<script>
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
</html>