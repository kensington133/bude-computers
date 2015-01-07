<?php
    include '../../funcs/init.php';

    unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
    $check = is_loggedin();
    if($check == false)
    {
	header('Location: /index.php');
	exit();
    }
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  	<title>View all jobs</title>

  <?php require_once '../../funcs/head.php'; ?>

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
		<h1>Job List</h1>
		<?php
			$jobData = getAllJobs();

			// printr($jobData);

			foreach($jobData as $job)
			{
				echo "<div class='panel' style='overflow: hidden;'>";
					echo "<div class='large-10 medium-10 columns'>";
						echo "<h5>".ucwords($job['contact_name'])." - ". date('l jS \of F Y', strtotime($job['date_submitted']))."</h5>";
						echo "<a href='/home/jobs/index.php?id=".$job['job_number']."'>View Job &raquo;</a>";
					echo "</div>";
					echo "<div class='large-2 medium-2 columns'>";
						echo "<a class='button tiny' style='margin-top: 10px;' href='tel:".$job['contact_phone']."'>Call: ".$job['contact_phone']."</a>";
					echo "</div>";
				echo "</div>";
			}
		?>

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
		    <p class="right">Website by <a href="http://heybenshort.co.uk">Ben Short</a></p>
	      </div>

	    </div>
	</div>
      </footer>

    <!-- End Footer -->

    </div>
<!-- </div> -->
	<script src="/js/vendor/jquery.js"></script>
	<script src="/js/foundation.min.js"></script>
	<script>
		$(document).foundation();
	</script>
<!-- End Footer -->
</body>
</html>
