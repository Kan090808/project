<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="col-sm-4">
          <h1 class="card-title mb-0" style="font-weight:bold">貼文專區</h1>
        </div>
        <div class="col-sm-8">
          <button class="btn btn-success" data-toggle="modal" data-target="#newpost" style="margin-left:-40px">新增</button>
        </div>
        <div class="modal fade" id="newpost">
          <div class="modal-dialog modal-lg" style="transform: translate(0, -50%);top: 50%;margin: 0 auto;">
            <div class="modal-content">
              <div class="modal-header">
                <b class="modal-title col-sm-10">新增貼文</b>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

              </div>
              <div class="modal-body">
                <div class="container">
                  <div class="row">
                    <div class="form">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="formtitle">貼文標題</label>
                          <input type="text" class="form-control" id="formtitle">
                        </div>
                        <div class="form-group">
                          <label for="formcontent">貼文內容</label>
                          <textarea class="form-control" rows="20" id="formcontent"></textarea>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="container">
                          <div class="row">
                            <label for="googleservice">Google 服務</label>
                            <div class="form-group col-sm-12" id="googleservice">
                              <ul>
                                <li><label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Google Doc</span>
                                  </label></li>
                                <li><label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Google Form</span>
                                  </label></li>
                                <li><label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Google Sheet</span>
                                  </label></li>
                            </div>
                          </div>

                          <div class="row">
                            <div class="form-group">
                              <div id="uploadfile">

                                <div class="col-sm-4">
                                  <label class="btn btn-file btn-success waves-effect waves-light" type="button">上傳檔案
                                    <input type="file" class="form-control-file" id="file" style="display:none"
                                      onchange="FileDetails()" multiple>

                                  </label>
                                </div>
                                <div id="num"></div>
                                <div class="col-sm-12 table-responsive" style="max-height:300px;">
                                  <table class="form-table table-striped">
                                    <thead>
                                      <tr>
                                        <th>檔案名稱</th>
                                        <th>檔案大小</th>
                                      </tr>
                                    </thead>
                                    <tbody id="tb">

                                    </tbody>
                                  </table>

                                </div>
                              </div>
                            </div>
                          </div>
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
    </div>
    <div class="card-body post-area">
      <div class="container">
        <div class="row" style="margin-top:30px">
          <div class="panel-default col-sm-10" style="margin:0 auto;float:none">
            <div class="panel-heading bg-default txt-white">
              <span class="col-sm-1"><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
              <b>簡靖騰</b>
              <div class="small txt-white">November 2017</div>
            </div>
            <div class="panel-body">
              <div class="container">
                <div class="row">
                  <div class="card">
                    <div class="card-header">
                      <h5 style="font-weight:bold">貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容</h5>
                    </div>
                    <div class="card-block">
                      <div class="row">
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l1.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l2.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl2.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l3.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl3.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l4.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl4.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row" style="margin-top:30px">
          <div class="panel-default col-sm-10" style="margin:0 auto;float:none">
            <div class="panel-heading bg-default txt-white">
              <span class="col-sm-1"><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
              <b>簡靖騰</b>
              <div class="small txt-white">November 2017</div>
            </div>
            <div class="panel-body">
              <div class="container">
                <div class="row">
                  <div class="card">
                    <div class="card-header">
                      <h5 style="font-weight:bold">貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容貼文內容</h5>
                    </div>
                    <div class="card-block">
                      <div class="row">
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l1.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl1.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l2.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl2.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l3.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl3.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12">
                          <a href="assets/images/light-box/l4.jpg" data-toggle="lightbox" data-gallery="example-gallery">
                            <img src="assets/images/light-box/sl4.jpg" class="img-fluid" alt="">
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>