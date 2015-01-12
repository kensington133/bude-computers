<?php
    require_once 'funcs/init.php';

    ini_set('display_errors',1);
    error_reporting(E_ALL ^ E_NOTICE);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
    <title>Bude Computers | Job System</title>

    <link rel="stylesheet" href="css/foundation.css">
    <script src="js/vendor/modernizr.js"></script>
</head>
<body>

<nav class="top-bar">
    <section class="top-bar-section">
        <ul class="right">
            <li class="divider"></li>
            <li class="has-form"><a href="/regsiter/" class="button">Register</a></li>
            <li class="divider"></li>
        </ul>
    </section>
</nav>

<div class="row">
    <div class="small-12 columns text-center">
        <div class="small-12 text-center">
            <img src="<?php echo $_LOGO ?>" alt="slide image">
        </div>
    </div>
</div>

<?php
    if(!empty($_SESSION['errors'])) {
        switch ($_SESSION['errors']){
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
    <div class="large-8 medium-8 small-10 small-centered columns">

        <?php if($_GET['s'] == 'y') {
            echo '<div data-alert class="alert-box success">';
                echo 'You have been registered successfully, please log in below.';
                echo '<a href="#" class="close">&times;</a>';
            echo '</div>';
            }

            if($fail > 0){
                echo '<div data-alert class="alert-box alert">';
                    echo 'Unable to login, please try again, making sure you spelt everything correctly';
                    echo '<a href="#" class="close">&times;</a>';
                echo '</div>';
            }
        ?>

        <form action="/dologin.php" method="POST">
            <label for="uname">User Name</label>
            <input type="text" name="uname" class="<?php if($empty > 0 || $fail > 0) echo "error"; ?>" id="uname" value="<?php echo trim($uname); ?>" />
            <?php if($empty > 0) echo "<small class='error'>Enter your user name</small>"; ?>
            <?php //if($fail > 0) echo "<small class='error'>Check your user name</small>"; ?>

            <label for="pword">Password</label>
            <input type="password" name="pword" class="<?php if($empty > 0 || $fail > 0) echo "error"; ?>" id="pword"/>
            <?php if($empty > 0) echo "<small class='error'>Enter your password</small>"; ?>
            <?php //if($fail > 0) echo "<small class='error'>Check your password</small>"; ?>

            <input type="submit" class="large button expand text-center" value="Login" />
            <small>Need an account? <a href="/register/">Click Here</a> to register!</small>
        </form>
    </div>
</div>
    <? require_once 'includes/footer.php' ?>
</body>
</html>