<?php 
session_start();
$_SESSION["curfolderId"] = $_GET["id"];
$_SESSION["curfolderName"] = $_GET["name"];
$_SESSION["curfolderPage"] = $_GET["data-page"];
// $curfolderId = $_GET["id"];
// $_SESSION["curfolderName"] = $_GET["name"];
// $_SESSION["curfolderPage"] = $_GET["data-page"];
// var_dump($curfolderId);
// var_dump($_SESSION["curfolderName"]);
// var_dump($_SESSION["curfolderPage"]);
// echo $curfolderId;
// echo $_SESSION["curfolderName"];
// echo $_SESSION["curfolderPage"];
?>
<div class="container">
  <div class="row">
    <div class="main-header">
      <!-- <ol class="breadcrumb breadcrumb-title breadcrumb-arrow col-sm-8">
        <li class="breadcrumb-item"><a href="#">暨馬同學會</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">107</a>
        </li>
        <li class="breadcrumb-item"><b>資訊組</b>
        </li>
      </ol> -->
      <h3><?php echo $_SESSION["curfolderName"];echo ' -- ';echo $_SESSION["curfolderPage"]?></h3>
    </div>
  </div>
  <div class="row" style="margin-top:25px">
    <ul class="col-sm-4 nav nav-tabs tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#post" role="tab" aria-expanded="true">貼文專區</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#drive" role="tab" aria-expanded="true">檔案專區</a>
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