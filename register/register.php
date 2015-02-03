<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';
	$register = new Register();

	$utils->printr($register);

	unset($_SESSION['errors'], $_SESSION['data']);

	$utils->printr($_SESSION['errors']);

	if($_POST){

		/* Error Handling */
		$_SESSION['errors'] = [];

		/* User Details */
		$name = $_SESSION['data']['name'] = $_POST['name'];
		$username = $_SESSION['data']['username'] = $_POST['username'];
		$email = $_SESSION['data']['email'] = $_POST['email'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		/* Shop Details */
		$shopName = $_SESSION['data']['shopName'] = $_POST['shop_name'];
		$shopAddress = $_SESSION['data']['shopAddress'] = $_POST['address_line1'];
		$shopCity = $_SESSION['data']['shopCity'] = $_POST['address_city'];
		$shopCounty = $_SESSION['data']['shopCounty'] = $_POST['address_state'];
		$shopPostCode = $_SESSION['data']['shopPostCode'] = $_POST['address_zip'];

		/* Stripe Details */
		$stripeCard = $_POST['stripeToken'];
		$chosenPlan = $_SESSION['data']['plan'] = $_POST['plan'];

		$utils->printr($_POST);

		// $register->registerUser($stripeCard, $chosenPlan , $email, $stripeCustomer, $name, $userName, $password, $shopName, $shopAddress, $shopCity, $shopCounty, $shopPostCode);
	}
?>