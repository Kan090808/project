<!-- Side-Nav-->
<aside class="main-sidebar hidden-print ">
  <section class="sidebar" id="sidebar-scroll">

    <div class="user-panel">
      <div class="f-left image"><img src="assets/images/avatar-1.png" alt="User Image" class="img-circle"></div>
      <div class="f-left info">
        <?php
if ($_SESSION["status"] == "false") {
  echo '<p class="col-sm-6">' . $name . '</p><form class="col-sm-6" action="../html/control.php" method="post"><button class="btn btn-sm" type="submit" value="getClient" name="act">登入</button></form> ';
} else {
  echo '<p class="designation" style="font-size:20px">' . $name . '<i class="icofont icofont-caret-down m-l-5"></i></p>';
}
?>
      </div>
    </div>
    <!-- sidebar profile Menu-->
    <ul class="nav sidebar-menu extra-profile-list">
      <li>
        <a class="waves-effect waves-dark" >
          <i class="icon-user"></i>
          <span class="menu-text">個人資料</span>
          <span class="selected"></span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark">
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
      <li class="nav-level">平臺</li>
      <li id="searchclub">
        <a class="waves-effect waves-dark"><i class="icofont icofont-home-search"></i><span>搜尋社團</span></a>
      </li>
      <li>
        <a class="waves-effect waves-dark"><i class="icofont icofont-ui-chat"></i></i><span>討論區</span></a>
      </li>
      
      <?php
      
if ($_SESSION["status"] == "true") {
  if(count($groupName)!=0)
    echo '<li class="nav-level">社團</li>';
  for ($i = 0; $i < count($groupName); $i++) {
    echo '
      <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>' . $groupName[$i] . '</span><i
            class="icon-arrow-down"></i></a>
        <ul class="treeview-menu">';
        echo checkRole($initEmail,$groupName[$i]);
    if (!isset($_SESSION['notCrew'])) {
      if(checkRole($initEmail,$groupName[$i])>90||checkRole($initEmail,$groupName[$i])==79){
        echo"hahahahhahaahahahahahahahahahahahahahahahahhahahaahhahaahhahaa";
      echo '<li id="join">
            <a class="waves-effect waves-dark txt-success">
              <i class="icofont icofont-ui-note"></i>
              加入社團申請
            </a>
          </li>
          <li id="member">
            <a class="waves-effect waves-dark txt-warning">
              <i class="icofont icofont-ui-note"></i>
              幹部名單
            </a>
          </li>';
      }    
    }
    ;
    echo '<li id="club">
            <a class="waves-effect waves-dark" href="#!">
              <i class="icofont icofont-ui-home"></i>
              首頁
            </a>
          </li>
          <li id="calendar">
            <a class="waves-effect waves-dark" href="#!">
              <i class="icofont icofont-calendar"></i>
              日曆
            </a>
          </li><li>
          <a class="waves-effect waves-dark folder" id="folder" name='.$groupId[$i].'>
            <i class="icofont icofont-speech-comments"></i>
            幹部討論區
          </a>
        </li>';
    if (!isset($_SESSION['notCrew'])) {
      $currentFolderId = getCurrentYearGroup($groupId[$i], $currentYear[$i]);
      $cfolder         = getFolderList($currentFolderId, 2);
      $cfileName       = $cfolder[0];
      $cfileId         = $cfolder[1];
      $cfileType       = $cfolder[2];
      $cfileLastMod    = $cfolder[3];
      $cfileSize       = $cfolder[4];
      $zubieId         = '';
      $huodongId       = '';
      for ($k = 0; $k < count($cfileName); $k++) {
        if ($cfileName[$k] == "組別") {
          $zubieId = $cfileId[$k];
        }
        if ($cfileName[$k] == "活動") {
          $huodongId = $cfileId[$k];
        }
      }
      if($zubieId!=''){
        echo '<li class="treeview">
              <a class="waves-effect waves-dark" href="#!">
                <i class="icofont icofont-briefcase-alt-2"></i>
                <span>組別</span>
                <i class="icon-arrow-down"></i>
              </a>
              <ul class="treeview-menu">';
        $gfolder      = getFolderList($zubieId, 2);
        $gfileName    = $gfolder[0];
        $gfileId      = $gfolder[1];
        $gfileType    = $gfolder[2];
        $gfileLastMod = $gfolder[3];
        $gfileSize    = $gfolder[4];
        for ($j = 0; $j < count($gfileName); $j++) {
          echo '<li>
                    <a class="waves-effect waves-dark" href="#!">
                      <i class="icofont icofont-briefcase-alt-2"></i>
                      ' . $gfileName[$j] . '
                    </a>
                  </li>';
        }
        echo '</ul></li>';
      }
      if($huodongId!=''){
        echo '<li class="treeview">
              <a class="waves-effect waves-dark" href="#!">
                <i class="icofont icofont-social-aim"></i>
                <span>活動</span>
                <i class="icon-arrow-down"></i>
              </a>
              <ul class="treeview-menu">';
        $efolder      = getFolderList($huodongId, 2);
        $efileName    = $efolder[0];
        $efileId      = $efolder[1];
        $efileType    = $efolder[2];
        $efileLastMod = $efolder[3];
        $efileSize    = $efolder[4];
        for ($j = 0; $j < count($efileName); $j++) {
          echo '<li>
                    <a class="waves-effect waves-dark" href="#!">
                      <i class="icofont icofont-social-aim"></i>
                      ' . $efileName[$j] . '
                    </a>
                  </li>';
        }
        echo '</ul></li>';
      }
    }
    echo '<li class="treeview">
            <a class="waves-effect waves-dark" href="#!">
              <i class="icofont icofont-folder-search"></i>
              <span>歷屆</span>
              <i class="icon-arrow-down"></i>
            </a>
            <ul class="treeview-menu">';
    $allYears      = getfolderList($groupId[$i], 2);
    $ayfileName    = $allYears[0];
    $ayfileId      = $allYears[1];
    $ayfileType    = $allYears[2];
    $ayfileLastMod = $allYears[3];
    $ayfileSize    = $allYears[4];
    for ($j = 0; $j < count($ayfileName); $j++) {
      if (strpos($ayfileType[$j], "folder") && $ayfileId[$j] != $currentFolderId) {
        $lfolder      = getFolderList($ayfileId[$j], 2);
        $lfileName    = $lfolder[0];
        $lfileId      = $lfolder[1];
        $lfileType    = $lfolder[2];
        $lfileLastMod = $lfolder[3];
        $lfileSize    = $lfolder[4];
        echo '<li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>' . $ayfileName[$j] . '</span><i
                    class="icon-arrow-down"></i></a>
                <ul class="treeview-menu">';
        $lzubieId   = '';
        $lhuodongId = '';
        for ($k = 0; $k < count($lfileName); $k++) {
          if ($lfileName[$k] == "組別") {
            $lzubieId = $lfileId[$k];
          } else if ($lfileName[$k] == "活動") {
            $lhuodongId = $lfileId[$k];
          }
        }
        if($lzubieId!=''){
          echo '<li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icofont icofont-briefcase-alt-2"></i>
                  <span>組別</span>
                  <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">';
          $lgfolder      = getFolderList($lzubieId, 2);
          $lgfileName    = $lgfolder[0];
          $lgfileId      = $lgfolder[1];
          $lgfileType    = $lgfolder[2];
          $lgfileLastMod = $lgfolder[3];
          $lgfileSize    = $lgfolder[4];
          for ($l = 0; $l < count($lgfileName); $l++) {
            echo '<li>
                      <a class="waves-effect waves-dark" href="#!">
                        <i class="icofont icofont-briefcase-alt-2"></i>
                        ' . $lgfileName[$l] . '
                      </a>
                    </li>';
          }
          echo '</ul></li>';
        }
        if($lhuodongId!=''){
          echo '<li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                  <i class="icofont icofont-social-aim"></i>
                  <span>活動</span>
                  <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">';
          $lefolder      = getFolderList($lhuodongId, 2);
          $lefileName    = $lefolder[0];
          $lefileId      = $lefolder[1];
          $lefileType    = $lefolder[2];
          $lefileLastMod = $lefolder[3];
          $lefileSize    = $lefolder[4];
          for ($l = 0; $l < count($lefileName); $l++) {
            echo '<li>
                      <a class="waves-effect waves-dark" href="#!">
                        <i class="icofont icofont-social-aim"></i>
                        ' . $lefileName[$l] . '
                      </a>
                    </li>';
          }
          echo '</ul></li>';
        }
        echo '</ul></li>';
      }
    }
    echo '</ul></li></ul></li>';
    $zubieId         = '';
    $huodongId       = '';
    $lzubieId   = '';
    $lhuodongId = '';
  }
  
}
?>
    </ul>
  </section>
</aside>