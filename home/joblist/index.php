<?php
	require_once '../../funcs/init.php';

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	if(is_loggedin() == false) {
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
			$jobData = getAllJobs();

			foreach($jobData as $job) {
				$customer_data = get_customer_by_id($job['customer_id']);
				echo "<div class='panel' style='overflow: hidden;'>";
					echo "<div class='large-10 medium-10 columns'>";
						echo "<h5>".ucwords($customer_data['customer_name'])." - ". date('l jS \of F Y', strtotime($job['date_submitted']))."</h5>";
						echo "<a href='/home/jobs/index.php?id=".$job['job_number']."'>View Job &raquo;</a>";
					echo "</div>";
					echo "<div class='large-2 medium-2 columns'>";
						echo "<a class='button tiny' style='margin-top: 10px;' href='tel:".$customer_data['customer_phone']."'>Call: ".$customer_data['customer_phone']."</a>";
					echo "</div>";
				echo "</div>";
			}
		?>
	</div>
</div>

<? require_once '../../includes/footer.php'; ?>

</body>
</html>
