<?php $v="200px"?>
<!DOCTYPE html>
<html>

<head>
  <title>Get File Details</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script>
    function SubmitFormData() {
      var title = $("#title").val();
      var title2 = $("#title2").val();
      var belong = $("#belong").val();
      var type = $("#type").val();
      var mime = $("#mime").val();
      var newFileMime = $("input[type=radio]:checked").val();
      $.post("../html/control.php?act=newPostAttach", { title: title, title2: title2, belong: belong, type: type, mime: mime , newFileMime: newFileMime },
      function() {
        $('#results').load(location.href+' #results');
        $('#newattach')[0].reset();
      });
    }
    var testajax = function(){
      $.ajax(
        {
          url:,
          type: 'post',
          dataType: 'json',
          contentType: 'application/json',
          data: JSON.stringify(
            {
              ID: ,
              title: "ajax",
              intro: "example",
            }
          )
        }
      )
    }
    function clearAttach() {
      $.post("../html/control.php?act=clearChoseSession",
      function() {
        $('#results').load(location.href+' #results');
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
        $('#results').load(location.href+' #results');
        $('#allPost').load(location.href+' #allPost');
        $('#newattach')[0].reset();
      });
      // alert("success");
    }
  </script>
</head>

<body style="font:15px Calibri;">
  <?php
    require("../html/model.php");
    $initEmail = getEmail();
    $name = getName();
    
    list($groupName,$groupId,$currentYear) = getJoinedGroup($initEmail);
    $currentFolderId = getCurrentYearGroup($groupId[0], $currentYear[0]);
    echo $currentFolderId;
    $title = "";
    $attach = "";
    if(isset($_SESSION['tempTitle'])){
      $title = $_SESSION['tempTitle'];
    }
    echo "<br/>-------------post-------";
    $attach = "";
    $newPostAttach = "";
    if(isset($_SESSION['attach'])){
      $attach = base64_encode(serialize($_SESSION['attach']));
      // $attach = $_SESSION['attach'];
    }
    if(isset($_SESSION['newPostAttach'])){
      $newPostAttach = base64_encode(serialize($_SESSION['newPostAttach']));
      // $newPostAttach = $_SESSION['newPostAttach'];
    }
    echo '<form id="newattach" method="post">
    po 文標題
    <input type="text" id="title" value="'.$title.'"><br/>
    新開文件
    <input type="text" id="title2" value="">
    <input type="hidden" id="belong" value="'.$groupId[0].'">
    <input type="hidden" id="type" value="2">
    <input type="hidden" id="mime" value="doc">
    <input type="radio" name="newFileMime" value="doc"> doc
    <input type="radio" name="newFileMime" value="sheet"> sheet
    <input type="radio" name="newFileMime" value="slide"> slide
    <br>
    <input type="hidden" name="newPostAttach" value="'.$newPostAttach.'">
    <input type="hidden" name="postBy" value="'.$initEmail.'">
        
    <input type="button" id="submitattach" onclick="SubmitFormData();" value="Submit">
    <input type="button" id="createpost" value="newPost" onclick="createPost();">   
    <input type="button" id="clearattach" onclick="clearAttach();" value="Clear">
  </form>';
  
  ?>
  
  <div id="results">
    <?php 
    if(isset($_SESSION['newPostAttach'])){
      echo "<br/>要新開的文件";
      $temp = $_SESSION['newPostAttach'];
      for($x=0;$x<count($temp);$x++){
        list($newPostAttachTitle,$newPostAttachBelong,$newPostType,$newPostAttachMime)=$temp[$x];
        // echo '<pre>' . var_export($temp[$x], true) . '</pre>';
        echo "<br/>".$newPostAttachTitle."_".$newPostAttachBelong."_".$newPostType."_".$newPostAttachMime;
      }
    }else{
      echo "<br/>沒有要新開的文件";
    }
    ?>
  </div>
  <div id="allPost">
  <?php 
  
  echo "<br> show post-------------------";
  list($postId,$postTitle,$postAttach,$isMainAttach,$postBy)=getPost($groupId[0],2);
  for($x=0;$x<count($postId);$x++){
    if($isMainAttach[$x] == true){
      // var_dump($postAttach);
      echo "<br/>".$postTitle[$x];
      echo "<br>PostBy :". $postBy[$x];
      $link = getFileLink($postAttach[$x]);
      $emblink = getEmb($postAttach[$x]);
      echo "<a href='$link'>view/edit in docs</a><br/>";
      echo "<iframe src = '$emblink'></iframe>";
    }else{
      echo "<br/>帖文附件：".$postTitle[$x]."___".$postAttach[$x];
    } 
  }
  ?>
  </div>
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
  function attachGoogle() {

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