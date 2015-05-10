<?php
    require_once '../../php/init.php';

    //check if the user is logged in
    $utils->isLoggedIn();

    //save the current and previous pages to check for outputting session date
    $prevPage = $_SERVER['HTTP_REFERER'];
    $thisPage = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Create a New Job</title>
    <?php require_once $_PATH.'/includes/head.php'; ?>
</head>
<body>

    <?php require_once $_PATH.'/includes/menu.php'; ?>

    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <h1 class="text-center">Create a New Job</h1>

            <?php

                if(isset($_SESSION['errors']['save'])){
                    echo '<div data-alert class="alert-box alert">';
                                echo $_SESSION['errors']['save'];
                            echo '<a href="#" class="close">&times;</a>';
                        echo '</div>';
                }

                if($_GET['s'] == 'y') $y = "success";
                if( (isset($_SESSION['errors']['job_desc'])) || (isset($_SESSION['errors']['contact_name'])) ) $n = "disabled";
            ?>

            <form action="createjob.php" method="POST">
                <div class="large-6 medium-6 small-12 columns">
                    <input <?php if(isset($_SESSION['errors']['contact_name'])) echo "class='error'"; ?> type="text" name="contact_name" placeholder="Contact Name" value="<?php if($thisPage == $prevPage) echo $_SESSION['contact_name'];?>"/>
                    <?php if(isset($_SESSION['errors']['contact_name'])) echo $_SESSION['errors']['contact_name']; ?>

                    <input type="text" name="contact_address" placeholder="Address"/>

                    <input type='number' pattern='[0-9]*' name="contact_phone" placeholder="Phone Number"/>

                    <input type="text" name="contact_email" placeholder="Email Address"/>
                </div>

                <div class="large-6 medium-6 small-12 columns">
                    <input type="text" name="product_name" placeholder="Product Name"/>

                    <input type="text" name="w_password" placeholder="Login Password"/>

                    <textarea style='height:90px;' name="product_notes" placeholder='Notes'></textarea>
                </div>

                <div class="small-12 columns">
                    <textarea style='height:125px;' <?php if(isset($_SESSION['errors']['job_desc'])) echo "class='error'"; ?> name="job_description" placeholder="Job Description"><?php if($thisPage == $prevPage) echo $_SESSION['job_description']; ?></textarea>
                    <?php if(isset($_SESSION['errors']['job_desc'])) echo $_SESSION['errors']['job_desc']; ?>
                </div>

                <div class="small-4 columns text-center">
                    <h6>Charger</h6>
                    <div class="switch large">
                        <input id="chargerSwitch" name="charger" type="checkbox">
                        <label for="chargerSwitch"></label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>Bag</h6>
                    <div class="switch large">
                        <input id="bagSwitch" name="bag" type="checkbox">
                        <label for="bagSwitch"></label>
                    </div>
                </div>
                <div class="small-4 columns text-center">
                    <h6>Storage</h6>
                    <div class="switch large">
                        <input id="storageMedia" name="storage" type="checkbox">
                        <label for="storageMedia"></label>
                    </div>
                </div>

                <div class="small-10 medium-11 columns" style="margin-bottom: 45px;">
                    <label>Urgency</label>
                    <div class="range-slider" data-slider data-options="display_selector: #urgencyOutput; start: 1; end: 10;">
                        <span class="range-slider-handle" role="slider"></span>
                        <span class="range-slider-active-segment"></span>
                        <input type="hidden" name="urgency" id="urgency">
                    </div>
                </div>
                <div class="small-2 medium-1 columns">
                    <span id="urgencyOutput"></span>
                </div>

                <div class="small-12 column">
                    <input type="submit" class="button large expand <?php echo $y,$n?> fa-input" value="&#61639; Save" />
                </div>

            </form>
        </div>
    </div>
    <?php require_once $_PATH.'/includes/footer.php'; ?>
</body>
</html>
