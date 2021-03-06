<?php
	require_once '../../php/init.php';
	$jobFeatures = new JobFeature();

	//check if the page is being printed
	$google = filter_input(INPUT_GET, 'g', FILTER_VALIDATE_INT, array('options' => array('default' => -1)));

	//if not - check if user is logged in
	if($google === -1){
		$utils->isLoggedIn();
	}

	//calculate the amount of jobs to display using the $_GET values
	$totalJobs = $jobFeatures->getJobCount();
	$numJobsDisplay = filter_input(INPUT_GET, 'display', FILTER_VALIDATE_INT, array('options' => array('default' => 10, 'min_range' => 10)));
	$totalPages = ceil($totalJobs / $numJobsDisplay);
	$curPage = min($totalPages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' => array('default' => 1, 'min_range' => 1))));
	$queryOffset = ($curPage - 1) * $numJobsDisplay;
	$start = ($queryOffset + 1);
	$end = min(($queryOffset + $numJobsDisplay), $totalJobs);

	//create variables for the pagination links
	$firstURL = '?page=1&display='.$numJobsDisplay;
	$lastURL = '?page='.$totalPages.'&display='.$numJobsDisplay;
	$prevURL = ($curPage > 1)?'?page='.($curPage - 1): '?page='.$totalPages;
	$prevURL .= '&display='.$numJobsDisplay;
	$nextURL = ($curPage == $totalPages)? '?page=1' : '?page='.($curPage + 1);
	$nextURL .= '&display='.$numJobsDisplay;

	//get the job data using the calculated values
	$jobData = $jobFeatures->getJobReportData($numJobsDisplay, $queryOffset);

	$notStarted = [];
	$inProgress = [];

	if(count($jobData) > 0) {
		foreach ($jobData as $job) {

			//not started
			if($job['progress'] === '0'){
				array_push($notStarted, $job);
			}

			//in progress
			if($job['progress'] === '1'){
				array_push($inProgress, $job);
			}
		}
	}

	//function to sort array by urgency
	function urgencySort($a, $b){
		return $a['urgency'] < $b['urgency'];
	}
	//sort arrays by urgency level
	usort($notStarted, "urgencySort");
	usort($inProgress, "urgencySort");
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>View all jobs</title>
	<?php require_once $_PATH.'/includes/head.php'; ?>
</head>
<body>

<?php require_once $_PATH.'/includes/menu.php'; ?>
<div class="row">
	<div class="small-12 columns text-center">
		<div class="small-12 text-center">
			<a href="/home/">
				<img src="<?php echo $_LOGO ?>" alt="slide image">
			</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="small-12 columns">
		<h1>Job Report</h1>
		<ul class="button-group round even-5 hide-for-print">
			<li><a href="<?php echo $firstURL; ?>" class="button"><i class="fa fa-angle-double-left"></i></i> <span class="hide-for-small">First</span></a></li>
			<li><a href="<?php echo $prevURL; ?>" class="button"><i class="fa fa-angle-left"></i> <span class="hide-for-small">Previous</span></a></li>
			<li><a id="print_button" class="print_button button hide-for-print"><i class="fa fa-print"></i> <span class="hide-for-small">Print</span></a></li>
			<li><a href="<?php echo $nextURL; ?>" class="button"><span class="hide-for-small">Next</span> <i class="fa fa-angle-right"></i></a></li>
			<li><a href="<?php echo $lastURL; ?>" class="button"><span class="hide-for-small">Last</span> <i class="fa fa-angle-double-right"></i></a></li>
		</ul>
		<form class="hide-for-print">
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
		<div id="not-started">
			<h3>Not Started</h3>
			<?php
				if(count($notStarted) > 0){
					foreach ($notStarted as $nsJob) {
						echo '<div class=" ';
						switch ($nsJob['urgency']) {
							case '10':
							case '9':
							case '8':
								echo 'high-urgency-panel';
							break;
							case '7':
							case '6':
							case '5':
							case '4':
								echo 'medium-urgency-panel';
							break;
							case '3':
							case '2':
							case '1':
								echo 'low-urgency-panel';
							break;
							default:
								echo 'panel';
							break;
						}
					echo ' clearfix">';
							echo "<p>Job ID: <a href='/home/jobs/?id=$nsJob[job_number]'>$nsJob[job_number]</a></p>";
							echo "<p>Customer: $nsJob[customer_name]</p>";
							echo "<p>Date Submitted: ".$utils->niceDate($nsJob['datetime_submitted'], 'l jS \of F Y h:i:s A')."</p>";
							$jobDate = new DateTime($nsJob['datetime_submitted']);
							$curDate = new DateTime();
							$interval = $jobDate->diff($curDate);
							$daysBetween = $interval->format('%R%a days');
							echo "<p>Days Since: $daysBetween</p>";
						echo '</div>';
					}
				} else {
					echo '<p>All jobs have been started on this page</p>';
				}
			?>
		</div>
		<div id="in-progress">
			<h3>In Progress</h3>
			<?php
			if(count($inProgress) > 0){
				foreach ($inProgress as $ipJob) {
					echo '<div class=" ';
						switch ($ipJob['urgency']) {
							case '10':
							case '9':
							case '8':
								echo 'high-urgency-panel';
							break;
							case '7':
							case '6':
							case '5':
							case '4':
								echo 'medium-urgency-panel';
							break;
							case '3':
							case '2':
							case '1':
								echo 'low-urgency-panel';
							break;
							default:
								echo 'panel';
							break;
						}
					echo ' clearfix">';
						echo "<p>Job ID: <a href='/home/jobs/?id=$ipJob[job_number]'>$ipJob[job_number]</a></p>";
						echo "<p>Customer: $ipJob[customer_name]</p>";
						echo "<p>Date Submitted: ".$utils->niceDate($ipJob['datetime_submitted'], 'l jS \of F Y h:i:s A')."</p>";
						$jobDate = new DateTime($ipJob['datetime_submitted']);
						$curDate = new DateTime();
						$interval = $jobDate->diff($curDate);
						$daysBetween = $interval->format('%R%a days');
						echo "<p>Days Since: $daysBetween</p>";
					echo '</div>';
				}
			} else {
				echo '<p>No jobs in progress found!</p>';
			}
			?>
		</div>
		<ul class="button-group round even-5 hide-for-print">
			<li><a href="<?php echo $firstURL; ?>" class="button"><i class="fa fa-angle-double-left"></i></i> <span class="hide-for-small">First</span></a></li>
			<li><a href="<?php echo $prevURL; ?>" class="button"><i class="fa fa-angle-left"></i> <span class="hide-for-small">Previous</span></a></li>
			<li><a id="print_button" class="print_button button hide-for-print"><i class="fa fa-print"></i> <span class="hide-for-small">Print</span></a></li>
			<li><a href="<?php echo $nextURL; ?>" class="button"><span class="hide-for-small">Next</span> <i class="fa fa-angle-right"></i></a></li>
			<li><a href="<?php echo $lastURL; ?>" class="button"><span class="hide-for-small">Last</span> <i class="fa fa-angle-double-right"></i></a></li>
		</ul>
	</div>
</div>

<?php require_once $_PATH.'/includes/footer.php'; ?>

</body>
</html>
