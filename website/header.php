<!DOCTYPE html>
<html lang="en">

  <head>
    <title>社團管理平台</title>
    <!-- HTML5 Shim and Respond.js IE9 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
     <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
     <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
     <![endif]-->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <!-- iconfont -->
    <link rel="stylesheet" type="text/css" href="assets/icon/icofont/css/icofont.css">

    <!-- simple line icon -->
    <link rel="stylesheet" type="text/css" href="assets/icon/simple-line-icons/css/simple-line-icons.css">

    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <!-- Weather css -->
    <link href="assets/css/svg-weather.css" rel="stylesheet">

    <!-- Echart js -->
    <script src="assets/plugins/charts/echarts/js/echarts-all.js"></script>

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">

    <!-- Responsive.css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">

    <!--color css-->
    <link rel="stylesheet" type="text/css" href="assets/css/color/color-1.min.css" id="color" />

  </head>

  <body class="sidebar-mini fixed">
    <div class="loader-bg">
      <div class="loader-bar">
      </div>
    </div>
    <div class="wrapper">
      <!--   <div class="loader-bg">
    <div class="loader-bar">
    </div>
</div> -->
      <!-- Navbar-->
      <header class="main-header-top hidden-print">
        <a href="index.html" class="logo">
          <h1 class="img-fluid able-logo">社團管理平台</h1>
        </a>
        <nav class="navbar navbar-static-top">
          <!-- toggle button -->
          <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
          <!-- Navbar Right Menu-->
          <div class="navbar-custom-menu f-right">
            <ul class="top-nav">
              <!--Notification Menu-->
              <li class="dropdown pc-rheader-submenu message-notification search-toggle">
                <a href="#!" id="morphsearch-search" class="drop icon-circle txt-white">
                  <i class="icofont icofont-search-alt-1"></i>
                </a>
              </li>
              <li class="dropdown notification-menu">
                <a href="#!" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                  <i class="icon-bell"></i>
                  <span class="badge badge-danger header-badge">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="not-head">You have <b class="text-primary">4</b> new notifications.</li>
                  <li class="bell-notification">
                    <a href="javascript:;" class="media">
                      <span class="media-left media-icon">
                        <img class="img-circle" src="assets/images/avatar-1.png" alt="User Image">
                      </span>
                      <div class="media-body"><span class="block">Lisa sent you a mail</span><span class="text-muted block-time">2min
                          ago</span>
                      </div>
                    </a>
                  </li>
                  <li class="bell-notification">
                    <a href="javascript:;" class="media">
                      <span class="media-left media-icon">
                        <img class="img-circle" src="assets/images/avatar-2.png" alt="User Image">
                      </span>
                      <div class="media-body"><span class="block">Server Not Working</span><span class="text-muted block-time">20min
                          ago</span>
                      </div>
                    </a>
                  </li>
                  <li class="bell-notification">
                    <a href="javascript:;" class="media">
                      <span class="media-left media-icon">
                        <img class="img-circle" src="assets/images/avatar-3.png" alt="User Image">
                      </span>
                      <div class="media-body"><span class="block">Transaction xyz complete</span><span class="text-muted block-time">3
                          hours ago</span></div>
                    </a>
                  </li>
                  <li class="not-footer">
                    <a href="#!">See all notifications.</a>
                  </li>
                </ul>
              </li>
              <!-- chat dropdown -->
              <li class="pc-rheader-submenu ">
                <a href="#!" class="drop icon-circle displayChatbox">
                  <i class="icon-bubbles"></i>
                  <span class="badge badge-danger header-badge blink">5</span>
                </a>

              </li>
              <!-- window screen -->
              <li class="pc-rheader-submenu">
                <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                  <i class="icon-size-fullscreen"></i>
                </a>
              </li>
              <!-- User Menu-->
              <li class="dropdown">
                <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                  <span><img class="img-circle " src="assets/images/avatar-1.png" style="width:40px;" alt="User Image"></span>
                  <span> <?php echo $name ?> <i class=" icofont icofont-simple-down"></i></span>
                </a>
                <ul class="dropdown-menu settings-menu">
                  <li><a href="#!"><i class="icon-settings"></i> Settings</a></li>
                  <li><a href="profile.html"><i class="icon-user"></i> Profile</a></li>
                  <li><a href="message.html"><i class="icon-envelope-open"></i> My Messages</a></li>
                  <li class="p-0">
                    <div class="dropdown-divider m-0"></div>
                  </li>
                  <li><a href="lock-screen.html"><i class="icon-lock"></i> Lock Screen</a></li>
                  <li>
                    <a href="../html/control.php?act=logout" method="post">
                      <i class="icon-logout"></i> Logout 
                    </a>
                  </li>
                  </form>

                </ul>
              </li>
            </ul>

            <!-- search -->
            <div id="morphsearch" class="morphsearch">
              <form class="morphsearch-form">
                <input class="morphsearch-input" type="search" placeholder="Search..." />
                <button class="morphsearch-submit" type="submit">Search</button>
              </form>
              <div class="morphsearch-content">
                <div class="dummy-column">
                  <h2>People</h2>
                  <a class="dummy-media-object" href="#!">
                    <img class="round" src="http://0.gravatar.com/avatar/81b58502541f9445253f30497e53c280?s=50&d=identicon&r=G"
                      alt="Sara Soueidan" />
                    <h3>Sara Soueidan</h3>
                  </a>
                  <a class="dummy-media-object" href="#!">
                    <img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G"
                      alt="Shaun Dona" />
                    <h3>Shaun Dona</h3>
                  </a>
                </div>
                <div class="dummy-column">
                  <h2>Popular</h2>
                  <a class="dummy-media-object" href="#!">
                    <img src="assets/images/avatar-1.png" alt="PagePreloadingEffect" />
                    <h3>Page Preloading Effect</h3>
                  </a>
                  <a class="dummy-media-object" href="#!">
                    <img src="assets/images/avatar-1.png" alt="DraggableDualViewSlideshow" />
                    <h3>Draggable Dual-View Slideshow</h3>
                  </a>
                </div>
                <div class="dummy-column">
                  <h2>Recent</h2>
                  <a class="dummy-media-object" href="#!">
                    <img src="assets/images/avatar-1.png" alt="TooltipStylesInspiration" />
                    <h3>Tooltip Styles Inspiration</h3>
                  </a>
                  <a class="dummy-media-object" href="#!">
                    <img src="assets/images/avatar-1.png" alt="NotificationStyles" />
                    <h3>Notification Styles Inspiration</h3>
                  </a>
                </div>
              </div><!-- /morphsearch-content -->
              <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
            </div>
            <!-- search end -->
            </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Side-Nav-->
      <?php include("sidebar.php"); ?>
      <!-- Sidebar chat start -->
      <?php include("chatbar.php"); ?>
      <?php include("showchat.php"); ?>
    </div>