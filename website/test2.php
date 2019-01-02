<!DOCTYPE html>
<html>

<head>
  <title>Get File Details</title>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script>
    var testajax = function(){
      alert("in");
      
      $.ajax({
        url: '../html/control.php?act=testajax',
        type: 'post',
        datatype: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
          title2: "title2",
          belong: "belong",
          type: "type",
          mime: "mime"
          
        }),
        async: false,
        success: function (data) {
          alert("success");
          ans = json_encode(data);
          $("#test").html("<p>title2: "+data.result.title2+"</p>");
        },
        error: function (data){
          alert("failed");

        },
        completed: function(data){
          alert("completed");
        }
      });

    }
    
  </script>
</head>
<body>
  <input type="button" value="testbtn" onclick="testajax();">
  <div id="test">
  
  </div>
</body>
</html>