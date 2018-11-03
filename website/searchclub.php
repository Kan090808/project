<div class="container">
  <div class="row">
    <div class="main-header">
      <h3 class="col-sm-4">社團管理平臺</h3><button class="btn btn-success" data-toggle="modal" data-target="#createclub">建立社團</button>
    </div>
  </div>
  <div class="row" style="margin-top:25px">
    <div class="card col-sm-8" style="margin:0 auto;float:none">
      <div class="card-header row">
        <h1 class="card-title mb-0 col-sm-4">搜尋社團</h1>
        <div class="col-sm-6">
          <div class="input-group mb-3">
            <form action="../html/control.php" method="post">
              <input type="hidden" name="pId" value="$currentFolderId.">
              <!-- <input type="submit" name="act" value="searchGroup"> -->
              <input type="text" class="form-control"  name="searchContent" placeholder="輸入社團名稱">
              <!-- <div class="input-group-btn">
                <button class="btn btn-success" type="submit" name="act" value="searchGroup"><i class="icofont icofont-ui-search"></i></button>
              </div> -->
            </form>
          </div>
        </div>
      </div>
      <!-- <div class="search-container">
          <input type="text" placeholder="Search..">
          <button class="btn btn-sm"type="submit"><i class="icofont icofont-ui-search"></i></button>
        </div> -->
      <div class="card-body">
        <div class="container">
          <div class="col-sm-12 table-responsive">
            <table class="table table-striped">
              <col width="80%">
              <col width="10%">
              <col width="10%">
              <tbody>
                <tr>
                  <td><a href="#">暨馬同學會</a></td>
                  <td><button class="btn btn-success">首頁</button></td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">暨馬同學會</a></td>
                  <td><button class="btn btn-success">首頁</button></td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">暨馬同學會</a></td>
                  <td><button class="btn btn-success">首頁</button></td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">暨馬同學會</a></td>
                  <td><button class="btn btn-success">首頁</button></td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
  <div class="modal fade" id="clubform">
    <div class="modal-dialog" style="transform: translate(0, -50%);top: 50%;margin: 0 auto;">
      <div class="modal-content">
        <div class="modal-header">
          <b class="modal-title col-sm-10">申請加入--暨馬同學會</b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfPB8WRtxptXI8uU8eGEvKp2QvwUOHrzQpO_WY_ffgz9dQTBg/viewform?embedded=true" width="100%" height="400px" frameborder="0" marginheight="0" marginwidth="0">正在加载...</iframe>
            </div>
            <!--form-->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success">發佈</button>
          <button type="button" class="btn btn-warning">取消</button>
        </div>
      </div>

    </div>
  </div>
  <div class="modal fade" id="createclub">
    <div class="modal-dialog" style="transform: translate(0, -50%);top: 50%;margin: 0 auto;">
      <div class="modal-content">
        <div class="modal-header">
          <b class="modal-title col-sm-10">申請加入--暨馬同學會</b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
            <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSfPB8WRtxptXI8uU8eGEvKp2QvwUOHrzQpO_WY_ffgz9dQTBg/viewform?embedded=true" width="100%" height="400px" frameborder="0" marginheight="0" marginwidth="0">正在加载...</iframe>
            </div>
            <!--form-->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success">發佈</button>
          <button type="button" class="btn btn-warning">取消</button>
        </div>
      </div>

    </div>
  </div>
  
</div>