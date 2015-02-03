<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

    $google = filter_input(INPUT_GET, 'g', FILTER_VALIDATE_INT, array('options' => array('default' => -1)));

    if($google === -1){
        if(!is_loggedin()) {
            header('Location: /index.php');
            exit();
        }
    }

    $job_data = get_lastjob($_GET['jobID']);
    $job_times = get_jobtime_by_id($_GET['jobID']);
    $customer_data = get_customer_by_id($_GET['customerID']);
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
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 medium-6 large-6 columns small-centered">
            <h1 class="hide-for-print">Create a New Job</h1>
            <?php
                if($_GET['s'] == 'y') {

                    echo '<p>Job Number: '.$_GET['jobID'].'<p>';

                    echo '<p>Submitted on: '. nice_date($job_times['date_submitted'], 'l jS \of F Y') .' at '. nice_date($job_times['time_submitted'], 'h:i A') .'<p>';

                    foreach($customer_data as $name => $value){
                        if(!empty($value)) {
                            $boom = explode('_', $name);
                            $namefull = $boom[0]. ' ' . $boom[1];
                            echo '<p>'.ucwords($namefull).': '.nl2br($value).'</p>';
                        }
                    }

                    foreach ($job_data as $name => $value) {

                        if(!empty($value)) {
                            $boom = explode('_', $name);
                            $namefull = $boom[0]. ' ' . $boom[1];

                            if(($namefull == "job description") || ($namefull == "job notes")) {
                                echo '<p>'.ucwords($namefull).':<br />';
                                echo nl2br($value) . '</p>';
                            } else {
                                echo '<p>'.ucwords($namefull).': '.nl2br($value).'</p>';
                            }
                        }
                    }
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
