<?php
include 'funcs/init.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Bude Computers | Job System</title>


  <link rel="stylesheet" href="css/foundation.css">


  <script src="js/vendor/custom.modernizr.js"></script>

</head>
<body>

<!-- Navigation -->

  <nav class="top-bar">
    <ul class="title-area">
      <!-- Title Area -->
      <li class="name">
        <h1>
          <a href="#">

          </a>
        </h1>
      </li>
      <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
    </ul>

    <section class="top-bar-section">
        <!-- Right Nav Section -->
        <ul class="right">
            <!-- <li><a href="/">Home</a></li> -->
        </ul>
    </section>
  </nav>

  <!-- End Top Bar -->

  <!--<div class="row">-->
    <div class="small-12 columns text-center">

    <!-- <div class="small-3 columns">&nbsp;</div> -->

    <!-- Content Slider -->
    <!-- <div class="small-6 columns text-centre"> -->
        <div class="row">
            <div class="small-12 hide-for-small text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <!-- <div class="small-3 columns">&nbsp;</div> -->
    <!-- End Content Slider -->

    <!-- Mobile Header -->

      <div class="row">
        <div class="small-12 columns show-for-small text-center">

          <img src="<?php echo $_LOGO ?>" alt="slide image">

        </div>
      </div><br>

    <!-- End Mobile Header -->
    <?php
        if(!empty($_SESSION['errors']))
        {
            switch ($_SESSION['errors'])
            {
                case 'empty':
                    $empty = 1;
                    break;
                case 'fail':
                    $fail = 1;
                    break;
            }
        }
        if(!empty($_SESSION['uname'])){ $uname = $_SESSION['uname']; }
    ?>
    <div class="row">
        <div class="small-12 small-centered columns">
            <form action="/dologin.php" method="POST">
                <div class="large-8 medium-6 small-12 medium-centered large-centered columns">
                    <label for="uname">User Name</label>
                    <input type="text" name="uname" class="<?php if($empty > 0 || $fail > 0) echo "error"; ?>" id="uname" value="<?php echo trim($uname); ?>" />
                    <?php if($empty > 0) echo "<small class='error'>Enter your user name</small>"; ?>
                    <?php if($fail > 0) echo "<small class='error'>Check your user name</small>"; ?>

                    <label for="pword">Password</label>
                    <input type="password" name="pword" class="<?php if($empty > 0 || $fail > 0) echo "error"; ?>" id="pword"/>
                    <?php if($empty > 0) echo "<small class='error'>Enter your password</small>"; ?>
                    <?php if($fail > 0) echo "<small class='error'>Check your password</small>"; ?>

                    <div class="text-center">
                        <input type="submit" class="large button expand text-center" value="Login" />

                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- End Content -->


    <!-- Footer -->

      <footer class="row hide-for-small">
        <div class="small-12 columns"><hr>
            <div class="row">

              <div class="small-6 columns">
                  <p>&copy; Ben Short</p>
              </div>

              <div class="small-6 columns">
                    <p class="right">Website Design by <a href="http://heybenshort.co.uk">Ben Short</a></p>
              </div>

            </div>
        </div>
      </footer>

    <!-- End Footer -->

<!--</div>-->
	<script src="/js/vendor/jquery.js"></script>
	<script src="/js/foundation.min.js"></script>
	<script>
	$(document).foundation();
	</script>
<!-- End Footer -->
</body>
</html>