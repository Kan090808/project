<!-- Side-Nav-->
<aside class="main-sidebar hidden-print ">
  <section class="sidebar" id="sidebar-scroll">

    <div class="user-panel">
      <div class="f-left image"><img src="assets/images/avatar-1.png" alt="User Image" class="img-circle"></div>
      <div class="f-left info">
        <?php if ($_SESSION["status"] == "false") {
          echo '<p class="col-sm-6">' . $name . '</p><form class="col-sm-6" action="../html/control.php" method="post"><button class="btn btn-sm" type="submit" value="getClient" name="act">登入</button></form> ';
        } else {
          echo '<small>' . $name . '</small><p class="designation">暨馬同學會會長<i class="icofont icofont-caret-down m-l-5"></i></p>';
        }
        ?>
      </div>
    </div>
    <!-- sidebar profile Menu-->
    <ul class="nav sidebar-menu extra-profile-list">
      <li>
        <a class="waves-effect waves-dark" href="profile.html">
          <i class="icon-user"></i>
          <span class="menu-text">個人資料</span>
          <span class="selected"></span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="javascript:void(0)">
          <i class="icon-settings"></i>
          <span class="menu-text">設定</span>
          <span class="selected"></span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="../html/control.php?act=logout" method="post">
          <i class="icon-logout"></i>
          <span class="menu-text">登出</span>
          <span class="selected"></span>
        </a>
      </li>
    </ul>
    <!-- Sidebar Menu-->
    <ul class="sidebar-menu">
      <li class="active treeview">
        <a class="waves-effect waves-dark" href="index.php">
          <i class="icon-speedometer"></i><span>設定</span>
        </a>
      </li>
      <?php if($_SESSION["status"] == "true"){
        for($i=0;$i<count($groupName);$i++){
          echo '<li class="nav-level">社團</li>
      <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>'.$groupName[$i].'</span><i
            class="icon-arrow-down"></i></a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              首頁
            </a>
          </li>
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              日曆
            </a>
          </li>';
          if(!isset($_SESSION['notCrew'])){
            $list = listFolderTree($groupId[$i]);
            for($j=0;$j<count($list);$j++){
              echo '<li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  <span>'.$list[$j][0].'</span>
                  <i class="icon-arrow-down"></i>
                </a>';
                // $listFolder = listFolderTree($list[$j][1]);
                // for($k=0;$k<count($listFolder);$k++)
                // {
                // echo '<ul class="treeview-menu">
                //   <li>
                //     <a class="waves-effect waves-dark" href="#!">
                //       <i class="icon-arrow-right"></i>
                //       <span>'.$listFolder[$k][0].'</span>
                //     </a>
                //   </li>';
                // echo '</ul>';
              // echo $list[$j][0];
              // echo $list[$j][1];
              echo "<br/>";
            }
          }
        }

  
  if(!isset($_SESSION['notCrew']))
  {
    echo '<li class="treeview">
    <a class="waves-effect waves-dark" href="#!">
      <i class="icon-arrow-right"></i>
      <span>活動</span>
      <i class="icon-arrow-down"></i>
    </a>

    <ul class="treeview-menu">
      <li>
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-arrow-right"></i>
          校慶
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              财政
            </a>
          </li>
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              <span>文書組</span>
            </a>

          </li>
        </ul>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-arrow-right"></i>
          大馬周
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              财政
            </a>
          </li>
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              <span>文書組</span>
            </a>

          </li>
        </ul>
      </li>
    </ul>
  </li>
  <li class="treeview">
    <a class="waves-effect waves-dark" href="#!">
      <i class="icon-arrow-right"></i>
      <span>歷屆</span>
      <i class="icon-arrow-down"></i>
    </a>

    <ul class="treeview-menu">
      <li>
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-arrow-right"></i>
          <b>107</b>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              組別
              <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  财政
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  <span>文書組</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              活動
              <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  校慶
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  <span>大馬周</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="#!">
          <i class="icon-arrow-right"></i>
          <b>106</b>
          <i class="icon-arrow-down"></i>
        </a>
        <ul class="treeview-menu">
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              組別
              <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  财政
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  <span>文書組</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="waves-effect waves-dark" href="#!">
              <i class="icon-arrow-right"></i>
              活動
              <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  校慶
                </a>
              </li>
              <li>
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icon-arrow-right"></i>
                  <span>大馬周</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</ul>
</li>';
  }
}
  ?>
    </ul>
  </section>
</aside>