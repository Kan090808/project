<?php require("../html/model.php");?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="col-sm-3">
          <h1 class="card-title mb-0 " style="font-weight:bold">貼文專區</h1>
        </div>
        <div class="col-sm-8">
          <button class="btn btn-success" data-toggle="modal" data-target="#newpost">新增</button>
        </div>
      </div>
      <div class="card-body post-area">
        <div class="container">

          <?php 
                echo $curfolderId;
                list($postId,$postTitle,$postAttach,$isMainAttach)=getPost($curfolderId,2);
                for($x=0;$x<count($postId);$x++){
                  if($isMainAttach[$x] == true){
                    // var_dump($postAttach);
                    echo '<div class="row" style="margin-top:30px">
                    <div class="panel-default col-sm-10" style="margin:0 auto;float:none">
                      <div class="panel-heading bg-default txt-white">
                        <span class="col-sm-1"><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;"
                            alt="User Image"></span>
                        <b>簡靖騰</b>
                        <div class="small txt-white">November 2017</div>
                      </div>
                      <div class="panel-body">
                        <div class="container">';
                    echo "<div class='row'>
                    <div class='card'>
                      <div class='card-header'>".$postTitle[$x];
                    $link = getFileLink($postAttach[$x]);
                    $emblink = getEmb($postAttach[$x]);
                    echo "<a href='$link'>編輯貼問內容</a></div>";
                    echo "<div class='card-body'><iframe src = '$emblink' width='100%' height='300px'></iframe></div>";
                    echo "<div class='card-block'>
                    <div class='row'>";
                  }else{
                    // $postAttach;
                    if(strpos(checkMimeType($postAttach[$x]), 'spreadsheet')){
                      echo "<div class='col-xl-2 col-lg-3 col-sm-1 col-xs-1'><a href=''><img src='assets/images/sheet.png' width='100%'></a></div>";
                    }
                    if(strpos(checkMimeType($postAttach[$x]), 'presentation')){
                      echo "<div class='col-xl-2 col-lg-3 col-sm-1 col-xs-1'><a href=''><img src='assets/images/slide.webp' width='100%'></a></div>";
                    }
                    if(strpos(checkMimeType($postAttach[$x]), 'document')){
                      echo "<div class='col-xl-2 col-lg-3 col-sm-1 col-xs-1'><a href=''><img src='assets/images/slide.webp' width='100%'></a></div>";
                    }
                    // echo "<br/>帖文附件：".$postTitle[$x]."___".$postAttach[$x];
                    // echo checkMimeType($postAttach[$x]);
                  }
                  echo "</div></div></div></div></div>
                  </div>
                </div>
              </div>"; 
                }
                
                ?>
        </div>
      </div>
      <div class="modal fade" id="newpost">
        <div class="modal-dialog modal-lg" style="transform: translate(0, -50%);top: 50%;margin: 0 auto;">
          <div class="modal-content">
            <div class="modal-header">
              <b class="modal-title col-sm-10">新增貼文</b>
              <button type="button" class="close" data-dismiss="modal" onclick="clearnewpost()">&times;</button>

            </div>
            <div class="modal-body">
              <div class="container">
                <div class="row">
                  <!-- <div class="form"> -->
                  <?php 
                      $title = "";
                      $attach = "";
                      $attach = "";
                      $newPostAttach = "";
                      
                      ?>
                  <form id="createPost" method="post">
                    <div class="col-sm-6">
                      <div class="form-group row">
                        <label for="formtitle" class="col-sm-4">貼文標題</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control form-control-sm" id="title" value="">
                        </div>
                      </div>
                      <div class="row">
                        <label class="col-sm-4">Google 服務</label>
                        <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#newGattach"
                          value="新增Google附件">
                        <input type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#selectGattach"
                          value="從Drive選擇">
                      </div>
                      <div id="cgAttach">
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
                    </div>
                    <div class="col-sm-6">
                      <div class="container">
                        <div class="row">

                        </div>

                        <div class="row">
                          <div class="form-group">
                            <label class="col-sm-4">一般檔案</label>
                            <div id="uploadfile">
                              <div>
                                <label class="btn btn-file btn-success waves-effect waves-light" type="button">上傳檔案
                                  <input type="file" class="form-control-file" id="file" style="display:none" onchange="FileDetails()"
                                    multiple>

                                </label>
                              </div>
                              <br />
                              <div class="col-sm-12 table-responsive" style="max-height:500px;">
                                <div id="num"></div>
                                <br />
                                <table class="form-table table-striped" width="100%">
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
                  </form>
                  <!-- </div> -->
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
      <div class="modal fade" id="newGattach" data-backdrop="static">
        <div class="modal-dialog" style="transform: translate(0, -50%);top: 50%;margin: 0 auto;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-sm-10">創建Google附件</h5>
              <button type="button" class="close" data-dismiss="modal" onclick="clearnewg()">&times;</button>
            </div>
            <div class="modal-body">
              <div class="container">
                <form id="createGattach" method="post">
                  <div class="form-group row">
                    <label for="formtitle" class="col-sm-4">google附件名稱</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control form-control-sm" id="title2" value="">
                    </div>
                  </div>
                  <label for="googleservice" class="col-sm-4">Google 服務</label>
                  <div class="form-radio col-sm-8" id="googleservice">
                    <div class="radio radio-inline">
                      <label><input type="radio" class="form-check-input" name="newFileMime" value="doc"><i class="helper"></i>Google
                        Doc</label>
                    </div>
                    <div class="radio radio-inline">
                      <label><input type="radio" class="form-check-input" name="newFileMime" value="sheet"><i class="helper"></i>Google
                        Sheet</label>
                    </div>
                    <div class="radio radio-inline">
                      <label><input type="radio" class="form-check-input" name="newFileMime" value="slide"><i class="helper"></i>Google
                        Slide</label>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <input class="btn btn-success" type="button" id="submitattach" onclick="SubmitFormData();" value="Submit"
                data-dismiss="modal">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>