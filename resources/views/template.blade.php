<!DOCTYPE HTML>

<html>
  <head>
    <title>{{$title}}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <meta name="author" content="author name" />
    <meta name="copyright" content="(c) 2018 SharePair. All rights reserved." />
    <meta name="designer" content="designer name" />
    <meta name="keywords" content="SharePair, Share, Pair, sharepair, share, pair, SHAREPAIR, SHARE, PAIR" />
    <meta name="robots" content="all" />

    <link rel="icon" href="/images/avatar.png">

    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    @yield('headjs')

    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->

    @yield('css')
  </head>
  <body>

    <!-- Wrapper -->
      <div id="wrapper">
        <!-- Main -->
          <div id="main">
            <div class="inner">

              <!-- Header -->
                <header id="header" style="text-align: center;">
                  <a href="index" title="Go to home page." class="logo"><strong>SharePair</strong></a>
                </header>

                @yield('content')

            </div>
          </div>

        <!-- Sidebar -->
          <div id="sidebar">
            <div class="inner">

              <!-- Search -->
              @if(Session::exists('user'))
                <section id="search" class="alt">
                  <div class="row uniform">
                    <div class="12u$" style="text-align: center;">
                      <a href="create-announcement" title="Create study announcement and publish it." class="button default">Create Announcement</a>
                    </div>
                    <div class="12u$" style="text-align: center;">
                      <a href="find-pair?page=1&sort=p_desc&search=" title="Find a study pair and send a message or a study request." class="button default">Find a Pair</a>
                    </div>
                  </div>
                </section>
              @endif

              <!-- Menu -->
                <nav id="menu">

                  @if(Session::exists('user'))
                  <header class="major">
                    <span class="image main" style="margin-left: 0; width: 64px; min-width: 64px; height: 64px; min-height: 64px;">
                      <?php echo '<img src="' . Session::get('user')->GetPhoto() . '">' ?>
                    </span>
                    <h2>{{Session::get('user')->GetName()}} {{Session::get('user')->GetSurname()}}</h2>
                  </header>
                  <ul>
                    <li><a href="profile">Profile</a></li>
                    <li><a href="messages?page=1&sort=d_desc">Messages <?php if(Session::get('unreaded_mes') > 0) echo '<b style="font-size: 15px;">(' . Session::get('unreaded_mes') . ')</b>'; ?> </a></li>
                    <li><a href="appointments?page=1&show=all&search=">Appointments <?php if(Session::get('unreaded_app') > 0) echo '<b style="font-size: 15px;">(' . Session::get('unreaded_app') . ')</b>'; ?> </a></li>
                    <li><a href="announcements?page=1&sort=o_desc&show=all&search=">Announcements</a></li>
                    <li><a href="logout">Logout</a></li>
                  </ul>
                  <br>
                  @endif

                  <header class="major">
                    <h2>Menu</h2>
                  </header>
                  <ul>
                    <li><a href="index">Homepage</a></li>
                    <li><a href="about">About SharePair</a></li>
                    <li><a href="contact">Leave a Message</a></li>
                  </ul>
                </nav>

              <!-- Section -->
                <section>
                  <header class="major">
                    <h2>Get in touch</h2>
                  </header>
                  <p>You can contact with us for any issue.</p>
                  <ul class="contact">
                    <li class="fa-envelope-o">
                      <a href="mailto:email">Name 1</a> /
                      <a href="mailto:email">Name 2</a>
                    </li>
                    <li class="fa-phone"><a href="tel:+903125868000">+90 123 456 7899</a></li>
                    <li class="fa-share-alt">
                      <a href="https://twitter.com/" target="_blank" class="icon fa-twitter"></a>&nbsp;&nbsp;&nbsp;
                      <a href="https://tr-tr.facebook.com/" target="_blank" class="icon fa-facebook"></a>
                    </li>
                    <li class="fa-home">
                      Address
                    </li>
                  </ul>
                </section>

              <!-- Footer -->
                <footer id="footer">
                  <p class="copyright">
                    SharePair &copy; All rights reserved.<br>
                  </p>
                </footer>

            </div>
          </div>

      </div>

    <!-- Scripts -->
      <script src="assets/js/jquery.min.js"></script>
      <script src="assets/js/skel.min.js"></script>
      <script src="assets/js/util.js"></script>
      <!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
      <script src="assets/js/main.js"></script>
      @yield('footjs')

  </body>
</html>
