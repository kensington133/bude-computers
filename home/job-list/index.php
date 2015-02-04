<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';
	$jobFeatures = new JobFeature();

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	$utils->isLoggedIn();

	$totalJobs = $jobFeatures->getJobCount();
	$numJobsDisplay = filter_input(INPUT_GET, 'display', FILTER_VALIDATE_INT, array('options' => array('default'   => 10, 'min_range' => 10)));
	$totalPages = ceil($totalJobs / $numJobsDisplay);
	$curPage = min($totalPages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array('default'   => 1, 'min_range' => 1))));
	$queryOffset = ($curPage - 1) * $numJobsDisplay;
	$start = ($queryOffset + 1);
	$end = min(($queryOffset + $numJobsDisplay), $totalJobs);

	$firstURL = '?page=1&display='.$numJobsDisplay;
	$lastURL = '?page='.$totalPages.'&display='.$numJobsDisplay;
	$prevURL = ($curPage > 1)?'?page='.($curPage - 1): '?page='.$totalPages;
	$prevURL .= '&display='.$numJobsDisplay;
	$nextURL = ($curPage == $totalPages)? '?page=1' : '?page='.($curPage + 1);
	$nextURL .= '&display='.$numJobsDisplay;

	$jobData = $jobFeatures->getJobListPage($numJobsDisplay, $queryOffset);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Job List</title>
	<?php require_once $_PATH.'/includes/head.php'; ?>
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
	<div class="small-12 columns">
		<h1>Job List</h1>
		<ul class="button-group round even-4">
			<li><a href="<?php echo $firstURL; ?>" class="button"><i class="fa fa-angle-double-left"></i></i> First</a></li>
			<li><a href="<?php echo $prevURL; ?>" class="button"><i class="fa fa-angle-left"></i> Previous</a></li>
			<li><a href="<?php echo $nextURL; ?>" class="button">Next <i class="fa fa-angle-right"></i></a></li>
			<li><a href="<?php echo $lastURL; ?>" class="button">Last <i class="fa fa-angle-double-right"></i></a></li>
		</ul>
		<form>
			<input type="hidden" name="page" value="<?php echo $curPage ?>" />
			<select name="display">
				<?php
					for($i = 1; $i <= 100; $i++){
						if($i % 10 === 0){
							echo '<option value="'.$i.'"';
							if($i === $numJobsDisplay) {
								echo ' selected="selected" ';
							}
							echo '>Show '.$i.' Jobs per page</option>';
						}
					}
				?>
			</select>
		</form>
		<?php
			foreach($jobData as $job) {
				$utils->printJobCard($job);
			}
			echo '<p class="text-center">'. $curPage .' of '. $totalPages .' pages, displaying '. $start .' - '. $end .' of '. $totalJobs .' results</p>';
		?>
		<ul class="button-group round even-4">
			<li><a href="<?php echo $firstURL; ?>" class="button"><i class="fa fa-angle-double-left"></i></i> First</a></li>
			<li><a href="<?php echo $prevURL; ?>" class="button"><i class="fa fa-angle-left"></i> Previous</a></li>
			<li><a href="<?php echo $nextURL; ?>" class="button">Next <i class="fa fa-angle-right"></i></a></li>
			<li><a href="<?php echo $lastURL; ?>" class="button">Last <i class="fa fa-angle-double-right"></i></a></li>
		</ul>
	</div>
</div>

<?php require_once $_PATH.'/includes/footer.php'; ?>

</body>
</html>
