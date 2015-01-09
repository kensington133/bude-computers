<?php
	require_once '../funcs/init.php';

	// if(is_loggedin() == false) {
	// 	header('Location: ../index.php');
	// 	exit();
	// }
?>
<!DOCTYPE html>
<!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
<head>
	<title>Register</title>
	<?php require_once '../includes/head.php'; ?>
</head>
<body>

	<?php require_once '../funcs/menu.php'; ?>

	<div class="row">
		<div class="small-12 columns text-center">
			<div class="small-12 text-center">
				<img src="<?php echo $_LOGO ?>" alt="slide image">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="small-10 small-centered columns">
			<h1>Register New User</h1>

			<form action="register.php" method="POST">
				<input type="text" <?php if($_SESSION['errors']['username']) echo 'class="error"'; ?> placeholder="Username" name="username" />
				<? if($_SESSION['errors']['username']) echo $_SESSION['errors']['username']; ?>

				<input type="email" <?php if($_SESSION['errors']['email']) echo 'class="error"'; ?> placeholder="Email" name="email" />
				<? if($_SESSION['errors']['email']) echo $_SESSION['errors']['email']; ?>

				<input type="password" <?php if($_SESSION['errors']['password']) echo 'class="error"'; ?> placeholder="Password" name="password" />
				<? if($_SESSION['errors']['password']) echo $_SESSION['errors']['password']; ?>

				<input type='number' <?php if($_SESSION['errors']['shop_id']) echo 'class="error"'; ?> pattern='[0-9]*' placeholder="Shop ID" name="shop_id" />
				<? if($_SESSION['errors']['shop_id']) echo $_SESSION['errors']['shop_id']; ?>

				<input type="submit" class="button expand" value="Save"/>
			</form>

		</div>
	</div>

	<? require_once '../includes/footer.php'; ?>

</body>
</html>
