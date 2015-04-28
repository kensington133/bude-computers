<?php
require_once $_PATH.'/includes/stripe/Stripe.php';
Stripe::setApiKey("sk_test_0Sxn7xNw7OiqzZOIQZc9B7uM");

class User extends db {

	private $stripeCustomer;
	private $subscription;

	/*
	*	(int|string) $userID - id of the user to update
	*/
	public function getUserInfo($userID){
		$sql = "SELECT `name`,`username`,`email`,`shop_id`,`stripe_id` FROM `users_table` WHERE id = $userID";
		return $this->getSingleRow($sql);
	}

	/*
	*	(string) $stripeID - Stripe id of the user to update
	*/
	public function getStripeCustomer($stripeID){
		$this->stripeCustomer = Stripe_Customer::retrieve($stripeID);
		$this->subscription = $this->stripeCustomer->subscriptions->retrieve($this->stripeCustomer->subscriptions->data[0]->id);
		return $this->stripeCustomer;
	}

	/*
	*	(string) $newPlan - name of the new subscription plan
	*/
	public function updatePlan($newPlan){
		$errCount = 0;
		$generic = 'There was an error processing your request, please try again.';
		try {
			//set new subscription and save it
			$this->subscription->plan = $_POST['plan'];
			$this->subscription->save();
		} catch(Stripe_CardError $e) {
			// Since it's a decline, Stripe_CardError will be caught
			$errCount++;
			array_push($_SESSION['errors'], 'Sorry, Your card has been declined.');
		} catch (Stripe_InvalidRequestError $e) {
			// Invalid parameters were supplied to Stripe's API
			$errCount++;
			array_push($_SESSION['errors'], $generic);
		} catch (Stripe_AuthenticationError $e) {
			// Authentication with Stripe's API failed
			// (maybe you changed API keys recently)
			$errCount++;
			array_push($_SESSION['errors'], $generic);
		} catch (Stripe_ApiConnectionError $e) {
			// Network communication with Stripe failed
			$errCount++;
			array_push($_SESSION['errors'], 'Unable to connect the Stripe, please try again. If this problem persists please contact me ASAP!');
		} catch (Stripe_Error $e) {
			// Display a very generic error to the user, and maybe send yourself an email
			$errCount++;
			array_push($_SESSION['errors'], $generic);
			$body = $e->getJsonBody();
			$err  = $body['error'];
			$date = date('l jS \of F Y h:i:s A');
			$message = "Looks like we had an error processing a payment here are some details\n\n
				Name: ".$name."\n
				Email: ".$email."\n
				Plan: ".$chosenPlan."\n\n
				Stripe Error Info:\n
				HTTP Status ".$e->getHttpStatus()."\n
				Code: ".$err['code']."\n
				Params (can be empty): ".$err['param']."\n
				Error Message: ".$err['message']."\n";
			mail('ben@heybenshort.co.uk', "Stripe Payment Error! on ".$date, $message);

		} catch (Exception $e) {
			$errCount++;
			// Something else happened, completely unrelated to Stripe
			array_push($_SESSION['errors'], "Sorry, you've encountered an unknown error! Please try again.");
		}

		if($errCount > 0){
			$this->errorRedirect();
		} else {
			$this->succesRedirect();
		}
	}

	public function cancelPlan(){

		$errCount = 0;
		$canceledPlan = $this->subscription->cancel();

		if($canceledPlan->status == 'canceled'){
			$sql = "UPDATE `users_table` SET `user_level` = -1 WHERE `id` = $_SESSION[userid]";
			$this->updateData($sql);
		} else {
			$errCount++;
			array_push($_SESSION['errors'], "Sorry, We were unable to cancel your plan! Please try again.");
		}

		if($errCount > 0){
			$this->errorRedirect();
		} else {
			$this->cancelRedirect();
		}
	}

	public function getShopData(){
		$sql = "SELECT * FROM `shop_table` WHERE `shop_id` = $_SESSION[shopID] AND `manager_id` = $_SESSION[userid]";
		return $this->getSingleRow($sql);
	}

	private function errorRedirect(){
		header('Location: index.php?e=1');
		exit();
	}

	private function succesRedirect(){
		header('Location: index.php?s=1');
		exit();
	}

	private function cancelRedirect(){
		header('Location: ../../logout.php');
		exit();
	}
}
?>