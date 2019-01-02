<!-- 判斷是否是幹部，是幹部的話顯示可操作的一些按鈕-->
<div class="container">
  <div class="row">
    <div class="main-header">
      <h1 class="col-sm-10" style="font-weight:bold">暨馬同學會</h1>
    </div>
  </div>
  <div class="row" style="margin-top:25px">
    <ul class="nav nav-tabs tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#news" role="tab" aria-expanded="true">最新消息</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#download" role="tab" aria-expanded="true">表單下載</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#intro" role="tab" aria-expanded="true">社團介紹</a>
      </li>
    </ul>
    <div class="tab-content tabs">
      <div class="tab-pane active" id="news" role="tabpanel">
        <?php include("news.php");?>
      </div>
      <div class="tab-pane" id="download" role="tabpanel">
        <?php include("download.php");?>
      </div>
      <div class="tab-pane" id="intro" role="tabpanel">
        <?php include("intro.php");?>
      </div>
    </div>
  </div>
</div>