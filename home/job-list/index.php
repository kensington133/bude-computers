<?php
	require_once '../../funcs/init.php';

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	if(!is_loggedin()) {
		header('Location: /index.php');
		exit();
	}

	$totalJobs = get_job_count();
	// $numJobsDisplay = 10;
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

	$jobData = get_job_list($numJobsDisplay, $queryOffset);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Job List</title>
	<?php require_once '../../includes/head.php'; ?>
</head>
<body>

<?php require_once '../../includes/menu.php'; ?>
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
		<form class="joblist-dislay">
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
				$customer_data = get_customer_by_id($job['customer_id']);
				output_job_card($job, $customer_data);
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

<?php require_once '../../includes/footer.php'; ?>

</body>
</html>