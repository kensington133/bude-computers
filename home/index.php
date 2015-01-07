<?php
    include '../funcs/init.php';
    
    unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
    $check = is_loggedin();
    if($check == false)
    {
	header('Location: ../index.php');
	exit();
    }
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Create a Job</title>

  <?php require_once '../funcs/head.php'; ?>

</head>
<body>

<!-- Navigation -->

  <?php require_once '../funcs/menu.php'; ?>	 

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
	
	    <h1 class='text-center'>Workshop Repair</h1>
	    <div class="row">
		<div class="small-12 medium-8 large-6 columns small-centered text-center">
		    <a class='button large expand' href="newjob/" title='Create a New Job'>Create <br /> Job</a>
		</div>
		<div class="small-12 medium-8 large-6 columns small-centered text-center">
		    <a	class='button large expand' href="jobs/" title='View existing jobs'>Existing <br /> Jobs</a>
		</div>
		<div class="small-12 medium-8 large-6 columns small-centered medium-centered large-centered text-center">
		    <form action="gotojob.php" method="POST">
			<div class="row collapse">
			    <div class="small-8 columns">
				<input type='number' pattern='[0-9]*'  <?php if($_GET['e'] == '1') echo "class='error'";?> placeholder="Job ID" name="job_number"></input>
				<?php if($_GET['e'] == '1') echo "<small class='error'>Please provide a valid job ID</small>"; ?>
			    </div>
			    <div class="small-4 columns">
				<!-- <a href="#" class="button prefix">Go</a> -->
				<input type="submit" class="button prefix" value='Go'></input>
			    </div>
			</div>
		    </form>
		</div>
		 <div class="small-12 medium-8 large-6 columns small-centered medium-centered large-centered  text-center">
			<div data-alert class="alert-box warning">
			Notice: To search for a date, use the format yyyy-mm-dd or just yyyy or yyyy-mm etc...
			<a href="#" class="close">&times;</a>
			</div>
		    <form action="search.php" method="POST">
			<div class="row collapse">
			    <div class="small-8 columns">
				<input type='text'  <?php if($_GET['e'] == '2') echo "class='error'";?> placeholder="Search Jobs" name="search"></input>
				<?php if($_GET['e'] == '1') echo "<small class='error'></small>"; ?>
			    </div>
			    <div class="small-4 columns">
				<input type="submit" class="button prefix" value='Search'></input>
			    </div>
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
