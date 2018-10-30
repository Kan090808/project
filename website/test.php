<!DOCTYPE html>
<html>

<head>
  <title>Get File Details</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body style="font:15px Calibri;">
  <!--ADD INPUT OF TYPE FILE WITH THE MULTIPLE OPTION-->
  <p>
    <input type="file" id="file" onchange="FileDetails()"multiple />
  </p>

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
  <button>press</button>
  <a>hello2</a>
  <ul>
    <li>hello</li>
    <li><ul><li id="press">heheh</li></ul></li>
  </ul>
  <div id="divToReload">
  </div>
  <div id="divSrc">
  </div>
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
  $(document).ready(function() {

    $('#press').click(function() {

      var url = 'member.php';
      alert(event.target.id);
      $('#divToReload').load('member.php');

    });
  });
// }
</script>
</html>