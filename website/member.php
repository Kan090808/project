<?php include("cheader.php"); ?>
<!-- Sidebar chat end-->
<div class="content-wrapper">
  <!-- Container-fluid starts -->
  <!-- Main content starts -->
  <div class="container">
    <div class="row">
      <div class="main-header ">
        <h3 class="col-sm-2">暨馬同學會</h3>
        <button class="btn btn-warning">交接</button>
      </div>
    </div>
    <div class="row" style="margin-top:25px">
      <div class="col-sm-4">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">107屆幹部</h5>
          </div>
          <div class="card-body">
            <div class="container" style="margin:0 auto">
              <div class="row">
                <div class="col-sm-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>姓名</th>
                        <th>系級</th>
                        <th>組別</th>
                        <th>身份</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>簡靖騰</td>
                        <td>資管4</td>
                        <td>107</td>
                        <td>會長</td>
                        <td>
                          <button type="button" class="close" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td>葉潤安</td>
                        <td>資管4</td>
                        <td>資訊組</td>
                        <td>組長</td>
                        <td>
                          <button type="button" class="close" aria-label="close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">搜尋會員</h5>
          </div>
          <div class="card-body">
            <div class="container">
              <div class="row">
                <div class="form-group">
                  <div class="col-sm-3">
                    <input class="form-control" type="search" placeholder="名字">
                  </div>
                  <div class="col-sm-3">
                    <input class="form-control" type="search" placeholder="科系">
                  </div>
                  <div class="col-sm-3">
                    <input class="form-control" type="search" placeholder="興趣">
                  </div>
                  <div class="col-sm-3">
                    <input class="form-control" type="search" placeholder="志願組別">
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top:10px">
              <div class="col-sm-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th></th>
                        <th>姓名</th>
                        <th>系級</th>
                        <th>興趣</th>
                        <th>志願組別</th>
                        <th>Gmail</th>
                        <th>聯絡號碼</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td>簡靖騰</td>
                        <td>資管4</td>
                        <td>美術</td>
                        <td>美宣組</td>
                        <td>kanjingterng@gmail.com</td>
                        <td>0905620013</td>
                      </tr>
                      <tr>
                        <td><input type="checkbox"></td>
                        <td>葉潤安</td>
                        <td>資管4</td>
                        <td>剪片</td>
                        <td>資訊組</td>
                        <td>junanyeap@gmail.com</td>
                        <td>0901234567</td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <button class="btn btn-sm btn-success" style="margin-left:10px">新增幹部</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("footer.php");