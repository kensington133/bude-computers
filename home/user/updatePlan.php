<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

	if($_POST){

		$_SESSION['errors'] = [];
		$newPlan = $_POST['plan'];

		$userInfo = $user->getUserInfo($_SESSION['userid']);
		$stripeUser = $user->getStripeCustomer($userInfo['stripe_id']);

		if($newPlan !== 'cancel'){
			$user->updatePlan($newPlan);
		} else {
			$user->cancelPlan();
		}
	}
?>