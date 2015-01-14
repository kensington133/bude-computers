<?php
	require_once '../../funcs/init.php';

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	if(!is_loggedin()) {
		header('Location: /index.php');
		exit();
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
		<h1>Job List</h1>
		<?php
			$jobData = get_job_list();

			foreach($jobData as $job) {
				$customer_data = get_customer_by_id($job['customer_id']);
				output_job_card($job, $customer_data);
			}
		?>
	</div>
</div>

<?php require_once '../../includes/footer.php'; ?>

</body>
</html>
