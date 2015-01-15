<?php
	require_once 'funcs/init.php';

	if(!is_loggedin()) {
		header('Location: index.php');
		exit();
	}
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Add Test Data</title>
	<?php require_once 'includes/head.php'; ?>
</head>
<body>

	<?php require_once 'includes/menu.php'; ?>

	<div class="row">
		<div class="small-12 columns text-center">
			<div class="small-12 text-center">
				<img src="<?php echo $_LOGO ?>" alt="slide image">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-12 columns">
			<h1>Add Test Data</h1>

			<?php
				if($_GET['s'] == 'y') {
		            echo '<div data-alert class="alert-box success">';
		                echo 'Data has been added!';
		                echo '<a href="#" class="close">&times;</a>';
		            echo '</div>';
	        	}

	        	$empty = false;
	        	$text = false;
	        	$range = false;
	        	if($_SESSION['errors']){
	        		if(isset($_SESSION['errors']['empty'])){
	        			$empty = true;
	        		}
	        		if(isset($_SESSION['errors']['text'])){
	        			$text = true;
	        		}
	        		if(isset($_SESSION['errors']['range'])){
	        			$range = true;
	        		}

	        	}
            ?>

			<form action="2.php" method="POST">
				<div class="row collapse">
					<div class="small-10 columns">
						<input <?php if($_SESSION['errors']) echo 'class="error"'; ?> type="number" name="amount" placeholder="Amount of rows to add">
						<?php
							if($empty === true) echo $_SESSION['errors']['empty'];
							if($text === true) echo $_SESSION['errors']['text'];
							if($range === true) echo $_SESSION['errors']['range'];
						?>
					</div>
					<div class="small-2 columns">
						<input class="button postfix" type="submit" value="Go" />
					</div>
				</div>
			</form>
		</div>
	</div>

	<?php require_once 'includes/footer.php'; ?>

</body>
</html>
