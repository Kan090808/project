<?php
$path;
if(isset($_SESSION['uploadPath'])){
  $path = $_SESSION['uploadPath'];
  echo 'path';
}else{
  $path = "";
  echo 'not path, select a folder to upload';
}
echo '
<form action="control.php" method="post" enctype="multipart/form-data">
  Upload a File:
  <input type="text" name="path" value='$path'>
  <input type="file" name="myfile" id="fileToUpload">
  <input type="submit" name="act" value="uploadFile" >
</form>
';

?>