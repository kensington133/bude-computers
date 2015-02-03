<?php
require_once $_PATH.'/includes/stripe/Stripe.php';
Stripe::setApiKey("sk_test_0Sxn7xNw7OiqzZOIQZc9B7uM");

class Register extends db {

	private $errCount = 0;
	private $generic = 'There was an error processing your request, please try again.';
	private $stripeCard;
	private $chosenPlan;
	private $email;
	private $stripeCustomer;
	private $name;
	private $userName;
	private $password;
	private $shopName;
	private $shopAddress;
	private $shopCity;
	private $shopCounty;
	private $shopPostCode;
	private $managerID;
	private $newShopID;

	public function __construct(){
		parent::__construct();
		$this->getNewShopID();
	}

	public function getAllStripePlans(){
		$stripePlans = Stripe_Plan::all();
		return $stripePlans['data'];
	}

	public function registerUser($stripeCard, $chosenPlan, $email, $name, $userName, $password, $shopName, $shopAddress, $shopCity, $shopCounty, $shopPostCode){

		$this->stripeCard = $stripeCard;
		$this->chosenPlan = $chosenPlan;
		$this->email = $email;
		$this->name = $name;
		$this->userName = $userName;
		$this->password = $password;
		$this->shopName = $shopName;
		$this->shopAddress = $shopAddress;
		$this->shopCity = $shopCity;
		$this->shopCounty = $shopCounty;
		$this->shopPostCode = $shopPostCode;

		if( ($this->stripeCard) && ($this->chosenPlan) && ($this->email) ){
			$this->createStripeCustomer();
			if( ($this->name) && ($this->userName) && ($this->password) && ($this->email) && (is_object($this->stripeCustomer)) ){
				$this->createUser();
				if(($this->managerID) && ($this->shopName) && ($this->shopAddress) && ($this->shopCity) && ($this->shopCounty) && ($this->shopPostCode) ) {
					if($this->createShop()){
						if($this->errCount > 0){
							$this->errorRedirect();
						} else {
							$this->successRedirect();
						}
					}
				}
			}
		}

	public function outputSessionData($data){
		if($data !== ''){
			echo ' value="'.$data.'" ';
		}
	}

	private function errorRedirect(){
		header('Location: index.php?e=1');
		exit();
	}

	private function successRedirect(){
		header('Location: /index.php?s=y');
		exit();
	}

	private function createStripeCustomer(){

		try {
			$customer = Stripe_Customer::create(array(
				"description" => "Test customer for heybenshort.co.uk",
				"plan" => $this->chosenPlan,
				"email" => $this->email
			));
		} catch(Stripe_CardError $e) {
			$this->errCount++;
			array_push($_SESSION['errors'], 'Sorry, Your card has been declined.');
		} catch (Stripe_InvalidRequestError $e) {
			$this->errCount++;
			array_push($_SESSION['errors'], $this->generic);
		} catch (Stripe_AuthenticationError $e) {
			$this->errCount++;
			array_push($_SESSION['errors'], $this->generic);
		} catch (Stripe_ApiConnectionError $e) {
			$this->errCount++;
			array_push($_SESSION['errors'], 'Unable to connect the Stripe, please try again. If this problem persists please contact me ASAP!');
		} catch (Stripe_Error $e) {
			$this->errCount++;
			array_push($_SESSION['errors'], $this->generic);
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
			$this->errCount++;
			array_push($_SESSION['errors'], "Sorry, you've encountered an unknown error! Please try again.");
		}
		if($this->errCount === 0){
			$this->stripeCustomer = $customer;
		} else {
			$this->errorRedirect();
		}
	}

	private function getNewShopID(){
		$sql = "SELECT max(`shop_id`) FROM `users_table`";
		$result = $this->getFirstRowItem($sql);
		$newShopID = ($result + 1);
		$this->newShopID = $newShopID;
	}

	private function createUser(){

		$userSQL = 'INSERT INTO `users_table` VALUES
		(
			NULL,
			"'. mysqli_real_escape_string($this->dbLink, $this->name) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->username) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->password) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->email) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->stripeCustomer->id) .'",
			"3",
			"'.$this->newShopID.'"
		)';

		$this->managerID = $this->insertDataGetID($userSQL);
	}

	private function createShop(){

		$shopSQL = 'INSERT INTO `shop_table` VALUES
		(
			"'. mysqli_real_escape_string($this->dbLink, $this->shopName).'",
			"'. mysqli_real_escape_string($this->dbLink, $this->shopAddress) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->shopCity) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->shopCounty) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->shopPostCode) .'",
			"'. $this->newShopID .'",
			"'. $this->managerID .'"
		)';

		return $this->insertData($shopSQL);
	}

}
?>