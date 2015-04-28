<?php
    require_once '../../php/init.php';

    //check if the page is being printed
    $google = filter_input(INPUT_GET, 'g', FILTER_VALIDATE_INT, array('options' => array('default' => -1)));

    //if not - check if the user is logged in
    if($google === -1){
        $utils->isLoggedIn();
    }

    $jobData = $jobFeatures->getJobByID($_GET['id'], true);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <title>Print Job</title>
    <?php require $_PATH.'/includes/head.php'; ?>
</head>
<body>

    <?php require_once $_PATH.'/includes/menu.php'; ?>

    <div class="small-12 columns text-center">
        <div class="row">
            <div class="small-12 text-center">
                <img src="/img/<?php echo $_GET['uid'] ?>/logo.jpg" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-6 large-6 columns small-centered">
            <h1 class="hide-for-print">Print Job</h1>
            <?php
                if(ctype_digit($_GET['id'])) {

                    echo '<p>Job Number: '.$jobData['job_number'].'<p>';

                    echo '<p>Submitted on: '. $utils->niceDate($jobData['date_submitted'], 'l jS \of F Y') .' at '. $utils->niceDate($jobData['time_submitted'], 'h:i A') .'<p>';

                    if($jobData['last_updated']){
                        echo '<p>Last Updated: '.$jobData['last_updated'].'</p>';
                    }

                    echo '<p>Name: '. $jobData['customer_name'] .'</p>';

                    echo '<p>Email: '. $jobData['customer_email'] . '</p>';

                    echo '<p>Address: '. $jobData['customer_address'] . '</p>';

                    echo '<p>Phone: '. $jobData['customer_phone'] . '</p>';

                    echo '<p>Product Name: '. $jobData['product_name'] . '</p>';

                    echo '<p>Job Notes: <br>'. nl2br($jobData['job_notes']) . '</p>';

                    echo '<p>Job Description: <br>'. nl2br($jobData['job_description']) . '</p>';

                    echo '<p>Job Urgency: '. $jobData['urgency'] . '</p>';

                    if($jobData['work_done']){
                        echo '<p>Work Done: '.$jobData['work_done'].'</p>';
                    }

                    if($jobData['parts_used']){
                        echo '<p>Parts Used: '.$jobData['parts_used'].'</p>';
                    }

                    if($jobData['job_price']){
                        echo '<p>Job Price: &pound;'.$jobData['job_price'].'</p>';
                    }

                    echo '<div class="small-4 columns" style="padding: 0px;">';
                        echo '<p>Bag: '.ucwords($jobData['bag']).'</p>';
                    echo '</div>';
                    echo '<div class="small-4 columns" style="padding: 0px;">';
                        echo '<p>Charger: '.ucwords($jobData['charger']).'</p>';
                    echo '</div>';
                    echo '<div class="small-4 columns" style="padding: 0px;">';
                        echo '<p>Storage: '.ucwords($jobData['storage']).'</p>';
                    echo '</div>';
                }
            ?>
            <a id="print_button" class="print_button button large expand hide-for-print"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>

    <?php require_once $_PATH.'/includes/footer.php' ?>

</body>
</html>
