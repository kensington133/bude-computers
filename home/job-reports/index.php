<?php
	require_once '../../funcs/init.php';

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	if(!is_loggedin()) {
		header('Location: /index.php');
		exit();
	}

	$jobData = get_all_job_data();
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
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>View all jobs</title>
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
		<h1>Job Reports</h1>
		<div id="not-started">
			<h3>Not Started</h3>
			<?php
				foreach ($notStarted as $nsJob) {
					$customer_data = get_customer_by_id($nsJob['customer_id']);
					output_job_card($nsJob, $customer_data);
				}
			?>
		</div>
		<div id="in-progress">
			<h3>In Progress</h3>
			<?php
				foreach ($inProgress as $ipJob) {
					$customer_data = get_customer_by_id($ipJob['customer_id']);
					output_job_card($ipJob, $customer_data);
				}
			?>
		</div>
	</div>
</div>

<?php require_once '../../includes/footer.php'; ?>

</body>
</html>
