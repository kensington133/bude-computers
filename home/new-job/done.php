<?php
    require_once '../../php/init.php';

    $google = filter_input(INPUT_GET, 'g', FILTER_VALIDATE_INT, array('options' => array('default' => -1)));
    if($google === -1){
        $utils->isLoggedIn();
    }

    $jobData = $jobFeatures->getJobByID($_GET['jobID']);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]> <!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Create a New Job</title>
    <?php require $_PATH.'/includes/head.php'; ?>
</head>
<body>

    <?php require_once $_PATH.'/includes/menu.php'; ?>

    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <a href="/home/">
                	<img src="<?php echo $_LOGO ?>" alt="slide image">
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-6 large-6 columns small-centered">
            <h1 class="hide-for-print">New Job</h1>
            <?php
                if($_GET['s'] == 'y') {

                    echo '<p>Job Number: '.$_GET['jobID'].'<p>';

                    echo '<p>Submitted on: '. $utils->niceDate($jobData['date_submitted'], 'l jS \of F Y') .' at '. $utils->niceDate($jobData['time_submitted'], 'h:i A') .'<p>';

                    echo '<p>Name: '. $jobData['customer_name'] .'</p>';

                    echo '<p>Email: '. $jobData['customer_email'] . '</p>';

                    echo '<p>Address: '. $jobData['customer_address'] . '</p>';

                    echo '<p>Phone: '. $jobData['customer_phone'] . '</p>';

                    echo '<p>Product Name: '. $jobData['product_name'] . '</p>';

                    echo '<p>Job Notes: <br>'. nl2br($jobData['job_notes']) . '</p>';

                    echo '<p>Job Description: <br>'. nl2br($jobData['job_description']) . '</p>';

                    echo '<p>Job Urgency: '. $jobData['urgency'] . '</p>';
                }
            ?>

            <small>Terms and Conditions</small>
            <div class="tandc"></div>

            <a id="print_button" class="print_button button large expand hide-for-print"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
    <?php require_once $_PATH.'/includes/footer.php' ?>
</body>
</html>
