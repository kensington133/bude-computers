<?php
    include '../../funcs/init.php';
    // unset($_SESSION['errors']);
    $check = is_loggedin();
    if($check == false)
    {
        header('Location: ../../index.php');
        exit();
    }
    // print_r($_SESSION);
    $job_data = get_mostrecent_job();
/*     print_r($job_data); */
    $job_range = get_jobid_range();
    // print_r($job_range);
    $job_ids = getAllJobIDs();
    //printr($job_ids);
    if(count($job_ids) > 0){
	   foreach($job_ids as $key => $value)
	   {
            if(is_array($value) && $value['job_number'] == $job_data['job_number'])
            {
                $currentkey = $key;
            }
	   }
    }
	$currentjob = $job_data['job_number'];

	//echo $currentjob;
	//echo $currentkey;

	for($i = 0; $i <= count($job_ids); $i++)
	{
		$prevkey = ($currentkey - 1);
		$nextkey = ($currentkey + 1);
		if($i == count($job_ids))
		{
			$finalkey = $i;
		}
	}

	/*echo $prevkey.'<br/>';
	echo $nextkey.'<br/>';*/

	$previd = $job_ids[$prevkey]['job_number'];
	$nextid = $job_ids[$nextkey]['job_number'];
	/*echo 'Current Key = '.$currentkey.'<br/>';
	echo 'Final Key = '.$finalkey.'<br/>';*/

	if($nextkey == $finalkey)
	{
		$nextid = $job_ids[0]['job_number'];
	}
	if($previd == -1)
	{
		$previd = $job_ids[$finalkey-1]['job_number'];
	}
	/*echo 'Prev ID = '.$previd.'<br/>';
	echo 'Next ID = '.$nextid.'<br/>';*/

?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Existing Jobs</title>

  <?php require '../../funcs/head.php'; ?>

</head>
<body>

<!-- Navigation -->

  <?php include '../../funcs/menu.php'; ?>

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
        <h1 class="text-center">Existing Jobs</h1>
        <?php
            if(isset($_GET['id']))
            {
                $job_data = get_jobby_id($_GET['id']);
                $job_ids = getAllJobIDs();
                //printr($job_ids);

              	foreach($job_ids as $key => $value)
        		{
        			if(is_array($value) && $value['job_number'] == $job_data['job_number'])
        			{
        				$currentkey = $key;
        			}
        		}

                $currentjob = $job_data['job_number'];

    			for($i = 0; $i <= count($job_ids); $i++)
    			{
    				$prevkey = ($currentkey - 1);
    				$nextkey = ($currentkey + 1);
    				if($i == count($job_ids))
    				{
    					$finalkey = $i;
    				}
    			}

    			$previd = $job_ids[$prevkey]['job_number'];
    			$nextid = $job_ids[$nextkey]['job_number'];

    			if($nextkey == $finalkey)
    			{
    				$nextid = $job_ids[0]['job_number'];
    			}
    			if($prevkey == -1)
    			{
    				$previd = $job_ids[$finalkey-1]['job_number'];
    			}
            }
        ?>
        <h2 class="text-center"><?php echo nice_date($job_data['date_submitted']); ?> - <?php echo $job_data['time_submitted']; ?></h2>
        <div class="row">
            <div class="small-12 columns small-centered">
              <form action="updatejob.php" method="POST">
                <div class="small-12 columns">
                        <ul class="button-group even-4 round hide-for-print">
                          <li><a href="/home/jobs/index.php?id=<?php echo $previd; ?>" class="button small">Back</a></li>
                          <li><input type="submit" class="button small" value="Save" /></li>
                          <?php $url = "done.php?id=".$job_data['job_number']."&code=".date('U'); ?>
                          <li><a class="button small" href="<? echo $url ?>">Print</a></li>
                          <li><a href="/home/jobs/index.php?id=<?php echo $nextid; ?>" class="button small">Next</a></li>
                        </ul>
                    </div>
                        <div class="large-6 small-12 columns">
                          <label for="contact_name">Name</label>
                          <input type="text" name="contact_name" placeholder="Contact Name" value="<?php echo $job_data['contact_name']; ?>" />

                          <label for="contact_address">Address</label>
                          <input type="text" name="contact_address" placeholder="Address" value="<?php echo $job_data['contact_address']; ?>"/>

                          <label for="contact_phone">Phone Number</label>
                          <input type='number' pattern='[0-9]*' name="contact_phone" placeholder="Phone Number" value="<?php if($job_data['contact_phone'] != '0') echo $job_data['contact_phone']; ?>"/>

                          <label for="contact_email">Email Address</label>
                          <input type="email" name="contact_email" placeholder="Email Address" value="<?php echo $job_data['contact_email']; ?>"/>

                        </div>
                        <div class="large-6 small-12 columns">
                          <label for="product_name">Product Name</label>
                          <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $job_data['product_name']; ?>"/>

                          <label for="product_notes">Notes</label>
                          <textarea style='height:160px;' name="product_notes" placeholder='Notes'><?php echo $job_data['job_notes']; ?></textarea>
                        </div>
                      <div class="small-12 columns">
                        <label for="job_description">Job Description</label>
                        <textarea style='height:160px;' name="job_description" placeholder="Job Description"><?php echo $job_data['job_description']; ?></textarea>

                        <label for="work_done">Work Carried Out</label>
                        <textarea style='height:160px;' name="work_done" placeholder="Work Carried Out"><?php echo $job_data['work_done']; ?></textarea>
                      </div>

                      <div class="large-8 small-12 columns">
                        <label for="parts_used">Parts Used</label>
                        <textarea style='height:160px; max-width:100%;' name="parts_used" id="parts_used" placeholder="Parts Used" ><?php echo $job_data['parts_used']; ?></textarea>
                      </div>

                      <div class="large-4 small-12 columns">
                        <label for="job_price">Price</label>
                        <textarea style='height:160px;' name="job_price" id="job_price" placeholder="Price - inc VAT"><?php echo $job_data['job_price']; ?></textarea>
                      </div>
                      <input type="hidden" name="job_number" value="<?php echo $job_data['job_number'];?>">
                      <div class="small-12 columns">
                        <ul class="button-group even-4 round hide-for-print">
                          <li><a href="/home/jobs/index.php?id=<?php echo $previd; ?>" class="button small">Back</a></li>
                          <li><input type="submit" class="button small" value="Save" /></li>
                          <li><a class="button small" href="<? echo $url; ?>">Print</a></li>
                          <li><a href="/home/jobs/index.php?id=<?php echo $nextid; ?>" class="button small">Next</a></li>
                        </ul>
                    </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div class="row">

    <!-- End Content -->


    <!-- Footer -->

      <footer class="row hide-for-small">
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
