<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

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
		<h1>Job Statistics</h1>
		<div id="weekly">
			<h3>Weekly</h3>
			<div id="weeklyGraph">

			</div>
		</div>
		<div id="monthly">
			<h3>Monthly</h3>
			<div id="monthlyGraph">

			</div>
		</div>
		<div id="yearly">
			<h3>Yearly</h3>
			<div id="yearlyGraph">

			</div>
		</div>
	</div>
</div>

<?php require_once $_PATH.'/includes/footer.php'; ?>

</body>
</html>
