<div class="container">
  <div class="row">
    <div class="main-header">
      <ol class="breadcrumb breadcrumb-title breadcrumb-arrow col-sm-8">
        <li class="breadcrumb-item"><a href="#">暨馬同學會</a>
        </li>
        <li class="breadcrumb-item"><a href="#!">107</a>
        </li>
        <li class="breadcrumb-item"><b>資訊組</b>
        </li>
      </ol>
    </div>
  </div>
  <div class="row" style="margin-top:25px">
    <ul class="col-sm-4 nav nav-tabs tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#post" role="tab" aria-expanded="true">公告</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#drive" role="tab" aria-expanded="true">社團介紹</a>
      </li>
    </ul>
    <div class="tab-content tabs">
      <div class="tab-pane active" id="post" role="tabpanel">
        <?php include("news.php"); ?>
      </div>
      <div class="tab-pane" id="drive" role="tabpanel">
        <?php include("clubinfo.php"); ?>
      </div>
    </div>
  </div>
</div>