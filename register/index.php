<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

	$register = new Register();
	$plans = $register->getAllStripePlans();
	$utils->printr($register);
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Register</title>
	<?php require_once '../includes/head.php'; ?>
</head>
<body>

	<nav class="top-bar">
		<section class="top-bar-section">
			<ul class="right">
				<li class="divider"></li>
				<li class="has-form"><a href="/" class="button">Login</a></li>
				<li class="divider"></li>
			</ul>
	</section>
	</nav>

	<div class="row">
		<div class="small-12 medium-8 large-10 columns">
			<h1>Create a System</h1>
		</div>
		<div class="small-12 medium-4 large-2 columns medium-text-right large-text-right">
			<a href="https://stripe.com/" title="Secure payments powered by stripe!">
				<img class="stripe" alt="Secure payments powered by stripe!" data-interchange="[/img/stripe.png, (default)], [/img/stripe@2x.png, (retina)]" required/>
				<noscript><img class="stripe" src="/img/stripe.png"></noscript>
			</a>
		</div>
	</div>

	<div class="row">
		<div class="small-12 small-centered columns">
			<?php if($_GET['e'] == 1) {
					if(count($_SESSION['errors']) > 0){
						echo '<div data-alert class="alert-box alert">';
							foreach ($_SESSION['errors'] as $err) {
								echo $err.'<br>';
							}
							echo '<a href="#" class="close">&times;</a>';
						echo '</div>';
				}
			}
			?>

			<form id="register" action="register.php" method="POST" data-abide="ajax">

				<div class="row">
					<div class="small-12 medium-6 large-6 columns">
						<fieldset>
							<legend>Your Details</legend>
							<input type="text" name="name" placeholder="Your name" <?php if($_SESSION['data']['name']) $register->outputSessionData($_SESSION['data']['name']); ?> required/>
							<small class="error">Please provide your name</small>

							<input type="text" pattern="alpha_numeric" placeholder="Username" name="username" <?php if($_SESSION['data']['username']) $register->outputSessionData($_SESSION['data']['username']); ?> required/>
							<small class="error">Please provide a valid user name</small>

							<input type="email" placeholder="Email" name="email" <?php if($_SESSION['data']['email']) $register->outputSessionData($_SESSION['data']['email']); ?> required/>
							<small class="error">Please provide a valid email address</small>

							<input type="password" id="password" pattern="^[A-z0-9]+$" placeholder="Password" name="password" required/>
							<small class="error">Please provide a password</small>

							<input type="password" placeholder="Repeat Password" name="password2" data-equalto="password" required/>
							<small class="error">Your passwords do not match</small>

						</fieldset>
					</div>

					<div class="small-12 medium-6 large-6 columns">
						<fieldset>
							<legend>Shop Address</legend>

							<input type="text" pattern="^[A-z0-9 ]+$" name="shop_name" placeholder="Shop Name" <?php if($_SESSION['data']['shopName']) $register->outputSessionData($_SESSION['data']['shopName']); ?> required/>
							<small class="error">Please provide your shop's name</small>

							<input type="text" name="address_line1" placeholder="Address" <?php if($_SESSION['data']['shopAddress']) $register->outputSessionData($_SESSION['data']['shopAddress']); ?> required/>
							<small class="error">Please provide your shop address</small>

							<input type="text" name="address_city" placeholder="City" <?php if($_SESSION['data']['shopCity']) $register->outputSessionData($_SESSION['data']['shopCity']); ?> required/>
							<small class="error">Please provide the city your shop is located in</small>

							<input type="text" name="address_state" placeholder="County" <?php if($_SESSION['data']['shopCounty']) $register->outputSessionData($_SESSION['data']['shopCounty']); ?> required/>
							<small class="error">Please provide the county your shop is in</small>

							<input type="text" name="address_zip" pattern="^[A-z]{2}[0-9]{2}( |)[0-9]{1}[A-z]{2}$" placeholder="Post Code" <?php if($_SESSION['data']['shopPostCode']) $register->outputSessionData($_SESSION['data']['shopPostCode']); ?> required/>
							<small class="error">Please provide the post code of your shop e.e. AA111AA or AA11 1AA</small>

						</fieldset>
					</div>
				</div>



				<div class="row">
					<div class="small-12 columns">
						<div class="js-err">
							<div data-alert class="alert-box alert">
								<span class="err-text"></span>
								<a href="#" class="close">&times;</a>
							</div>
						</div>
						<fieldset>
							<legend>Subscription &amp; Payment</legend>

							<select name="plan" required>
								<option value>Please choose...</option>
								<?php
									foreach($plans as $item){
										$selected = ($item->id == $_SESSION['data']['plan'])? ' selected="selected" ': '';
										echo '<option value="'.$item->id.'" '.$selected.'>&pound;'. money_format('%!n', ($item->amount / 100)) .' per '. $item->interval .' - '. $item->name .'</option>';
									}
								?>
							</select>
							<small class="error">Please choose a subscription</small>

							<input type="text" pattern="card" id="number" placeholder="Card Number" required/>
							<small class="error">Please provide a valid card number</small>

							<div class="small-12 medium-12 large-3 columns" style="padding: 0px;">
								<input type="text" pattern="^[0-9]{2}$" id="exp_month" placeholder="Month of Expiry e.g. <?php echo date('m'); ?>" required />
								<small class="error">Please provide the expiry month of your card e.g. <?php echo date('m'); ?></small>
							</div>
							<div class="small-12 medium-12 large-3 columns" style="padding: 0px;">
								<input type="text" pattern="^(?:\d{2}){1,2}$" id="exp_year" placeholder="Year of Expiry e.g. <?php echo date('Y'); ?> or <?php echo date('y'); ?>" required />
								<small class="error">Please provide the expiry year of your card e.g. <?php echo date('Y'); ?> or <?php echo date('y'); ?></small>
							</div>
							<div class="small-12 medium-12 large-3 medium-offset-3 columns" style="padding: 0px;">
								<input type="text" pattern="^[0-9]{3}$" id="cvc" placeholder="Card Secutiry Code" required/>
								<small class="error">Please provide the CVC or Security code of the card, it is the last 3 digits on the back of the card</small>
							</div>
						</fieldset>

						<input type="submit" class="button expand" value="Get Started!" />
						<small>Already registered? <a href="/">Click Here</a> to login!</small>

					</div>
				</div>

			</form>
		</div>
	</div>

	<?php require_once '../includes/footer.php'; ?>

</body>
</html>
