<?php
	require_once '../php/init.php';

	if(!is_loggedin()) {
		header('Location: ../index.php');
		exit();
	}

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Create a Job</title>
	<?php require_once '../includes/head.php'; ?>
</head>
<body>

	<?php require_once '../includes/menu.php'; ?>

	<div class="row">
		<div class="small-12 columns text-center">
			<div class="small-12 text-center">
				<img src="<?php echo $_LOGO ?>" alt="slide image">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-12 medium-8 large-6 columns small-centered">
			<h1 class='text-center'>Workshop Repair</h1>

			<a class='button large expand' href="new-job/" title='Create a New Job'>Create <br /> Job</a>

			<a	class='button large expand' href="jobs/" title='View existing jobs'>Existing <br /> Jobs</a>

			<div data-alert class="alert-box warning">
				Notice: When searching for dates please use the full date representation e.g. <?php echo date('d/m/Y'); ?> and not <?php echo date('d/m/y'); ?>
				<a href="#" class="close">&times;</a>
			</div>

			<form action="search.php" method="POST">
				<div class="row collapse">
					<div class="small-8 columns">
						<input type='text'  <?php if($_GET['e'] == '2') echo "class='error'";?> placeholder="Please use the full date e.g. <?php echo date('Y'); ?> not <?php echo date('y'); ?>" name="search" />
						<?php if($_GET['e'] == '1') echo "<small class='error'></small>"; ?>
					</div>
					<div class="small-4 columns">
						<input type="submit" class="button prefix" value='Search' />
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php require_once '../includes/footer.php'; ?>

</body>
</html>
