<div class="container">
  <div class="row">
    <div class="main-header">
      <h3>社團管理平臺</h3>
    </div>
  </div>
  <div class="row" style="margin-top:25px">
    <div class="card">
      <div class="card-header row">
        <h1 class="card-title mb-0 col-sm-2">搜尋社團</h1>
        <div class="col-sm-4">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="輸入社團名稱">
            <div class="input-group-btn">
              <button class="btn btn-success" type="button"><i class="icofont icofont-ui-search"></i></button>
            </div>
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
              <col width="30%">
              <col width="60%">
              <col width="10%">
              <thead>
                <tr>
                  <th>社團名稱</th>
                  <th>簡介</th>
                  <th>提出申請</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><a href="#">暨馬同學會</a></td>
                  <td>Otto</td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">臺馬同學會</a></td>
                  <td>Otto</td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">Mark</a></td>
                  <td>Otto</td>
                  <td><button class="btn btn-info">申請</button></td>
                </tr>
                <tr>
                  <td><a href="#">Mark</a></td>
                  <td>Otto</td>
                  <td><button class="btn btn-info">申請</button></td>
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
              <div class="form">
                <div class="row">
                  <div class="form-group col-sm-3">
                    <label for="formtitle">姓名</label>
                    <input type="text" class="form-control" required="required" id="formtitle">
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="formtitle">學號</label>
                    <input type="text" class="form-control" required="required" id="formtitle">
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="formtitle">系所</label>
                    <input type="text" class="form-control" required="required" id="formtitle">
                  </div>
                  <div class="form-group col-sm-3">
                    <label for="formtitle">年級</label>
                    <input type="text" class="form-control" required="required" id="formtitle">
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-sm-6">
                    <label for="formtitle">Gmail</label>
                    <input type="text" class="form-control" required="required" id="formtitle">
                  </div>
                </div>
              </div>
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