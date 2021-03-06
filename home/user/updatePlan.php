<?php
	require_once '../../php/init.php';

	if($_POST){

		$_SESSION['errors'] = [];
		$newPlan = $_POST['plan'];

		$userInfo = $user->getUserInfo($_SESSION['userid']);
		$stripeUser = $user->getStripeCustomer($userInfo['stripe_id']);

		//depending of the user input send the corresponding call the the User class
		if($newPlan !== 'cancel'){
			$user->updatePlan($newPlan);
		} else {
			$user->cancelPlan();
		}
	}
?>