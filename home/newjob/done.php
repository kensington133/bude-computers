<?php
    require_once '../../funcs/init.php';
    $job_data = get_lastjob($_GET['jobID']);
    $customer_data = get_customer_by_id($_GET['customerID']);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]> <!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <title>Create a New Job</title>
    <?php require '../../includes/head.php'; ?>
</head>
<body>

    <?php require_once '../../funcs/menu.php'; ?>

    <div class="row">
        <div class="small-12 columns text-center">
            <div class="small-12 text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-6 columns small-centered">
            <h1 class="hide-for-print">Create a New Job</h1>
            <?php
                if($_GET['s'] == 'y') {

                    foreach($customer_data as $name => $value){
                        if(!empty($value)) {
                            $boom = explode('_', $name);
                            $namefull = $boom[0]. ' ' . $boom[1];
                            echo "<p>".ucwords($namefull).": ".nl2br($value)."</p>";
                        }
                    }

                    foreach ($job_data as $name => $value) {

                        if(!empty($value)) {
                            $boom = explode('_', $name);
                            $namefull = $boom[0]. ' ' . $boom[1];

                            if(($namefull == "job description") || ($namefull == "job notes")) {
                                echo "<p>".ucwords($namefull).":<br />";
                                echo nl2br($value) . "</p>";
                            } else {
                                echo "<p>".ucwords($namefull).": ".nl2br($value)."</p>";
                            }
                        }
                    }
                }
            ?>
            <a id="print_button" class="print_button button large expand hide-for-print">Print</a>
        </div>
    </div>
    <? require_once '../../includes/footer.php' ?>
</body>
</html>
