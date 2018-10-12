<!-- Side-Nav-->
<aside class="main-sidebar hidden-print ">
  <section class="sidebar" id="sidebar-scroll">

    <div class="user-panel">
      <div class="f-left image"><img src="assets/images/avatar-1.png" alt="User Image" class="img-circle"></div>
      <div class="f-left info">
        <?php if ($_SESSION["status"] == "false") {
          echo '<p class="col-sm-6">' . $name . '</p><form class="col-sm-6" action="../html/control.php" method="post"><button class="btn btn-sm" type="submit" value="getClient" name="act">登入</button></form> ';
        } else {
          echo '<small>' . $name . '</small><p class="designation">三聯會會長 <i class="icofont icofont-caret-down m-l-5"></i></p>';
        }
        ?>
      </div>
    </div>
    <!-- sidebar profile Menu-->
    <ul class="nav sidebar-menu extra-profile-list">
      <li>
        <a class="waves-effect waves-dark" href="profile.html">
          <i class="icon-user"></i>
          <span class="menu-text">View Profile</span>
          <span class="selected"></span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="javascript:void(0)">
          <i class="icon-settings"></i>
          <span class="menu-text">Settings</span>
          <span class="selected"></span>
        </a>
      </li>
      <li>
        <a class="waves-effect waves-dark" href="../html/control.php?act=logout" method="post">
          <i class="icon-logout"></i>
          <span class="menu-text">Logout</span>
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
echo '<li class="nav-level">社團</li>
      <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>暨馬同學會</span><i
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
          </li>
        </ul>
      </li>
      <li class="treeview"><a class="waves-effect waves-dark" href="#!"><i class="icofont icofont-company"></i><span>僑生聯誼會</span><i
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
          </li>
        </ul>
      </li>';
  }?>
    </ul>
  </section>
</aside>