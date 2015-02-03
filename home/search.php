<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title>Search Results</title>
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
			<form action="search.php" method="POST">
				<div class="row collapse">
					<div class="small-10 columns">
						<input type='text'  <?php if($_GET['e'] == '2') echo "class='error'";?> placeholder="Search Jobs - Please use the full date representation e.g. <?php echo date('d/m/Y'); ?> and not <?php echo date('d/m/y'); ?>" name="search" />
						<?php if($_GET['e'] == '1') echo "<small class='error'></small>"; ?>
					</div>
					<div class="small-2 columns">
						<input type="submit" class="button prefix" value='Search' />
					</div>
				</div>
			</form>
			<h1 class="hide-for-print">Search Results</h1>
			<?php
				if($_POST) {
					$result = search($_POST['search']);
					$count = count($result);
					echo "<h3>You searched for: '".$_POST['search']."'</h3>";
					echo "<h4>".$count." Results Found</h4>";

					if($count > 0) {
						foreach($result as $r) {
							$job_range = get_jobid_range();
							$job_number = $r['job_number'];
							$max = $job_range['max'];
							$min = $job_range['min'];

							if($job_number != "") {
								if(($job_number >= $min) && ($job_number <= $max)) {
									echo "<div class='panel' style='overflow: hidden;'>";
										echo "<div class='large-10 medium-10 columns'>";
											echo "<h5>Job ".$job_number."</h5>";
											echo "<h5>".ucwords($r['customer_name'])." - ". date('l jS \of F Y', strtotime($r['date_submitted']))."</h5>";
											echo "<a href='/home/jobs/index.php?id=".$job_number."'>View Job &raquo;</a>";
										echo "</div>";
											echo "<div class='large-2 medium-2 columns'>";
												echo "<a class='button small' style='margin-top: 10px;' href='/home/jobs/index.php?id=".$r['job_number']."'>View Job <i class='fa fa-angle-double-right'></i></a>";
											echo "</div>";
									echo "</div>";
								}
							}
						}
					}
				}
			?>
		</div>
	</div>
	<?php require_once $_PATH.'/includes/footer.php'; ?>
</body>
</html>