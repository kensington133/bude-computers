<?php
	require_once '../../funcs/init.php';

	if(!is_loggedin()) {
		header('Location: /index.php');
		exit();
	}

	$start = new DateTime('last sunday');
	$startWeek = $start->format('Y-m-d');
	$startCopy = clone($start);
	$endWeek = $startCopy->modify('+6 days')->format('Y-m-d');

	$jobData = get_jobs_between_dates($startWeek, $endWeek);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Job Live View</title>
	<meta http-equiv="refresh" content="300" />
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
	<div class="small-12 columns text-center">
		<h1>Jobs For Week: <small><?php echo $start->format('d/m/Y') .'&nbsp;-&nbsp;'. nice_date($endWeek, 'd/m/Y'); ?></small></h1>
		<?php foreach ($jobData as $job):?>
			<?php
			echo '<div class=" ';
				switch ($job['urgency']) {
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
			?>
				<div class="small-12 large-2 columns">
					<h6>Customer Name</h6>
					<p><?php echo $job['customer_name']; ?></p>
				</div>
				<div class="small-12 large-2 columns">
					<h6>Product Name</h6>
					<p><?php echo $job['product_name']; ?></p>
				</div>
				<div class="small-12 large-3 columns">
					<h6>Job Description</h6>
					<p><?php echo $job['job_description']; ?></p>
				</div>
				<div class="small-12 large-2 columns">
					<h6>Submitted On</h6>
					<p><?php echo nice_date($job['datetime_submitted'], 'd/m/Y H:i'); ?></p>
				</div>
				<div class="small-12 large-2 columns">
					<h6>Last Updated</h6>
					<p><?php echo nice_date($job['last_updated'], 'd/m/Y H:i'); ?></p>
				</div>
				<div class="small-12 large-1 columns">
					<h6>Urgency</h6>
					<p><?php echo $job['urgency']; ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<?php require_once '../../includes/footer.php'; ?>

</body>
</html>