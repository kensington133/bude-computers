<?php
        include '../../funcs/init.php';

        $code = $_GET['code'];


        $high = date("U", time() + 60);
        $low = date("U", time() - 60);

        // echo "Timestamp = $code <br> -60 Secs = $low <br> +60 secs = $high";

        //if timestamp is less than or greather than the 1 minute timeout - redirect to home page
        if( ($code < $low) || ($code > $high) )
        {
                header('Location: /home/');
                exit();
        }

        $job_data = get_lastjob_alldata($_GET['id']);
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Print Job</title>

  <?php require '../../funcs/head.php'; ?>

</head>
<body>

<!-- Navigation -->

  <?php require_once '../../funcs/menu.php'; ?>
  <!-- End Top Bar -->

<!--   <div class="row"> -->
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

    <div class="row">
        <div class="small-12 columns">

            <div class="row">
                <div class="small-6 columns small-centered">
                <h1 class="hide-for-print">Print Job</h1>
                <?php
                    if(ctype_digit($_GET['id']))
                    {
                        // echo "<ul class='small-10 columns'>";
                        //print_r($job_data);
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
                        // echo "</ul>";
                    }
                    ?>
                <a id="print_button" class="print_button button large expand hide-for-print">Print</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

    <!-- End Content -->


    <!-- Footer -->

      <footer class="row hide-for-small hidefor-print">
        <div class="small-12 columns"><hr>
            <div class="row">

              <div class="small-6 columns">
                  <p>&copy; Ben Short</p>
              </div>

              <div class="small-6  columns">
                    <p class="right">Website Design by <a href="http://heybenshort.co.uk">Ben Short</a></p>
              </div>

            </div>
        </div>
      </footer>

    <!-- End Footer -->

    </div>
<!-- </div> -->
	<script src="/js/vendor/jquery.js"></script>
	<script src="/js/foundation.min.js"></script>
	<script src="/js/print.js"></script>
	<script>
	$(document).foundation();
	</script>
<!-- End Footer -->
</body>
</html>
