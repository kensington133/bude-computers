<?php
include '../funcs/init.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width initial-scale=1, maximum-scale=1">
  <title>Search Results</title>
   
  <?php require '../funcs/head.php'; ?>

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
		<form action="search.php" method="POST">
			<div class="row collapse">
				<div class="small-10 columns">
					<input type='text'  <?php if($_GET['e'] == '2') echo "class='error'";?> placeholder="Search Jobs" name="search" />
					<?php if($_GET['e'] == '1') echo "<small class='error'></small>"; ?>
					</div>
					<div class="small-2 columns">
					<input type="submit" class="button prefix" value='Search' />
				</div>
			</div>
		</form>
                <h1 class="hide-for-print">Search Results</h1>
		<?php
			if($_POST)
			{
			        $result = search($_POST['search']);
			        $count = count($result);
				echo "<h3>You searched for: '".$_POST['search']."'</h3>";
				echo "<h4>".$count." Results Found</h4>";
			        //echo "<pre>".print_r($result,true)."</pre>";
			        if($count > 0)
			        {
				        foreach($result as $r)
				        {
						$job_range = get_jobid_range();
						$job_number = $r['job_number'];
						$max = $job_range['max'];
						$min = $job_range['min'];
	
						if($job_number != "")
						{
							if( ($job_number >= $min) && ($job_number <= $max) )
							{
								echo "<div class='panel'>";
								echo "<h5>".ucwords($r['contact_name'])." - ". date('l jS \of F Y', strtotime($r['date_submitted']))."</h5>";
								echo "<p>&raquo;<a href='/home/jobs/index.php?id=".$job_number."'>View Job</a></p>";
								echo "</div>";
							}
						}	
				        }
			        }
			
			}
                ?>
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