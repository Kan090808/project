<?php require("../html/model.php");header("Content-Type:text/html; charset=utf-8");?>
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
              <input type="text" class="form-control" name="searchContent" placeholder="輸入社團名稱" id="searchString" onkeyup=searchClub()>
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
              <tbody id="allClub">
                <?php 
                // require("../html/model.php");
                $email = getEmail();
                $allresult = allGroup();
                $arGroupId = $allresult[0];
                $arGroupName = $allresult[1];
                for($i=0;$i<count($arGroupName);$i++){
                  echo '<tr>
                  <td><a href="#">'.$arGroupName[$i].'</a></td>
                  <td><button class="btn btn-success">首頁</button></td>
                  <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button>
                </form></td>
                  </tr>';
                }
              ?>
                <!-- <td><button class="btn btn-info" data-toggle="modal" data-target="#clubform">申請</button></td> -->

                <!-- <tr>
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
                </tr> -->
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
          <b class="modal-title col-sm-10">申請加入</b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <form method='post' action='../html/control.php'>
                <input type='hidden' name='act' value='newMemberDetail'><br />
                name <input type='text' name='name' value=''><br />
                id <input type='text' name='id' value=''><br />
                email <input type='text' name='email' value='".$email."' readonly><br />
                gender <input type='radio' name='gender' value='male'> male
                <input type='radio' name='gender' value='female'> female<br />
                class <select name='class' size='3' multiple>
                  <option value='IM'>IM</option>
                  <option value='ECO'>ECO</option>
                  <option value='FINANCIAL'>FINANCIAL</option>
                  <option value='HAPPYHAPPY'>HAPPYHAPPY</option>
                </select><br />
                departMent <select name='department' size='3' multiple>
                  <option value='BIG'>BIG</option>
                  <option value='SUO'>SUO</option>
                  <option value='BO'>BO</option>
                </select><br />
                year <select name='year' size='4' multiple>
                  <option value='1'>1</option>
                  <option value='2'>2</option>
                  <option value='3'>3</option>
                  <option value='4'>4</option>
                  <option value='f'>other</option>
                </select><br />
                tel <input type='number' name='tel' value=''><br />
                diet <input type='radio' name='diet' value='meat'> meat
                <input type='radio' name='diet' value='vegatarian'> vegatarian<br />
                skill <input type='text' name='skill' value=''><br />
                perfer <input type='text' name='prefer' value=''><br />
                <input type='hidden' name='groupId' value='".$groupId."'>
                <input type='submit' value='Apply to join this Group'><br />
              </form>
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
          <b class="modal-title col-sm-10">申請建立社團</b>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="form">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="newclubName" class="col-sm-12">Text<label>
                    <!-- <div class="col-sm-10"> -->
                      <input class="form-control" type="text" id="newclubName">
                    <!-- </div> -->
                  </div>
                </div>
              </div>
            <!--form-->
            </div>
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