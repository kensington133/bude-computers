<?php
    require_once '../../funcs/init.php';

    $code = $_GET['code'];

    $high = date("U", time() + 30);
    $low = date("U", time() - 30);

    if(($code < $low) || ($code > $high)){
        header('Location: /home/');
        exit();
    }

    $job_data = get_lastjob_alldata($_GET['id']);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
    <title>Print Job</title>
    <?php require '../../includes/head.php'; ?>
</head>
<body>

    <?php require_once '../../funcs/menu.php'; ?>

    <div class="small-12 columns text-center">
        <div class="row">
            <div class="small-12 text-center">
                <img src="<?php echo $_LOGO ?>" alt="slide image">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-12 columns">
            <div class="row">
                <div class="small-6 columns small-centered">
                    <h1 class="hide-for-print">Print Job</h1>
                    <?php
                        if(ctype_digit($_GET['id']))
                        {
                            foreach ($job_data as $name => $value)
                            {
                                if(!empty($value))
                                {
                                    $boom = explode('_', $name);
                                    $namefull = $boom[0]. ' ' . $boom[1];

                                    if( ($namefull == "job description") || ($namefull == "job notes") )
                                    {
                                        echo "<p>".ucwords($namefull).":<br />";
                                        echo nl2br($value) . "</p>";
                                    }
                                    else
                                    {
                                        echo "<p>".ucwords($namefull).": ".nl2br($value)."</p>";
                                    }
                                }
                            }
                        }
                    ?>
                    <a id="print_button" class="print_button button large expand hide-for-print">Print</a>
                </div>
            </div>
        </div>
    </div>

    <? require_once '../../footer.php' ?>

</body>
</html>
