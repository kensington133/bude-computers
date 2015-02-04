<?php
	require_once '../../php/init.php';

	unset($_SESSION['errors'],$_SESSION['job_desc'],$_SESSION['contact_name']);
	$utils->isLoggedIn();

	$tabToShow = $_GET['tab'];
	$userInfo = $user->getUserInfo($_SESSION['userid']);

	$stripeUser = $user->getStripeCustomer($userInfo['stripe_id']);
	$subscriptions = $stripeUser->subscriptions->data;
	$plans = $register->getAllStripePlans();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>User Area</title>
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
		<h1>User Area</h1>
		<p>Hey <?php echo explode(' ', $userInfo['name'], 2)[0]; ?>, here your can change your plan type and user details.</p>
		<p>If you cancel you plan, your will be logged out once it's been cancelled and wont be able to log back in.</p>
	</div>
</div>

<div class="row">
	<div class="small-12 columns">
		<h3 id="your-info">Your Info</h3>
	</div>

	<div class="large-3 columns">
		<div class="panel callout">
		<h5>Date Joined</h5>
			<p><?php echo date('d/m/Y H:i', $stripeUser->created); ?></p>
		</div>
	</div>
	<div class="large-3 columns">
		<div class="panel callout">
		<h5>User Name</h5>
			<p><?php echo $userInfo['username']; ?></p>
		</div>
	</div>
	<div class="large-3 columns">
		<div class="panel callout">
		<h5>Email</h5>
			<p><?php echo $userInfo['email']; ?></p>
		</div>
	</div>
	<div class="large-3 columns">
		<div class="panel callout">
		<h5>Shop ID</h5>
			<p><?php echo $userInfo['shop_id']; ?></p>
		</div>
	</div>
</div>


<div class="row">
	<div class="small-12 columns">
	<?php
		if($_GET['e'] == 1) {
			if(count($_SESSION['errors']) > 0){
				echo '<div data-alert class="alert-box alert">';
					foreach ($_SESSION['errors'] as $err) {
						echo $err.'<br>';
					}
					echo '<a href="#" class="close">&times;</a>';
				echo '</div>';
			}
		}

		if($_GET['s'] == 1) {
			echo '<div data-alert class="alert-box success">';
				echo 'Your plan has been updated successfully.';
				echo '<a href="#" class="close">&times;</a>';
			echo '</div>';
		}
	?>
	<?php if($stripeUser->subscriptions->total_count > 0): ?>
		<?php foreach($subscriptions as $sub):
			$planParts = explode(':', $sub->plan->name, 2);
			$planName = $planParts[0];
			$planUsers = $planParts[1];
		?>
			<ul class="pricing-table">
				<li class="title"><?php echo $planName; ?></li>
				<li class="price">&pound;<?php echo money_format('%!n', ($sub->plan->amount / 100)); ?></li>
				<li class="bullet-item"><?php echo ucwords($sub->plan->interval).'ly'; ?> Billing</li>
				<li class="bullet-item"><?php echo $planUsers; ?></li>
				<?php if($sub->plan->trial_period_days): ?>
					<li class="bullet-item"><?php echo $sub->plan->trial_period_days ?> Day Trial</li>
					<li class="bullet-item">
						<?php
						if(date('U') < $sub->trial_end){
							echo 'Trial Ends: '. date('jS \of F Y h:i:s A', $sub->trial_end);
						} else {
							echo 'Trial Ended: '. date('jS \of F Y h:i:s A', $sub->trial_end);
						}
						?>
					</li>
				<?php endif; ?>
				<form id="updatePlan" method="POST" action="updatePlan.php" data-abide>
					<input type="hidden" name="stripeID" value="<?php echo $userInfo['stripe_id']; ?>">
					<li class="bullet-item">
						<select name="plan" class="small-12 medium-6" required>
							<option value>Please choose...</option>
							<?php
								foreach($plans as $item){
									echo '<option value="'.$item->id.'">&pound;'. money_format('%!n', ($item->amount / 100)) .' per '. $item->interval .' - '. $item->name .'</option>';
								}
							?>
							<option value="cancel">Cancel Subscription</option>
						</select>
					</li>
					<li class="cta-button"><input type="submit" class="button" value="Change Plan"/></li>
				</form>
			</ul>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</div>

<?php require_once $_PATH.'/includes/footer.php'; ?>

</body>
</html>
