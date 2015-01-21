<?php
	require_once '../funcs/init.php';
	require_once '../includes/stripe/Stripe.php';
	Stripe::setApiKey("sk_test_0Sxn7xNw7OiqzZOIQZc9B7uM");

	unset($_SESSION['errors'], $_SESSION['data']);

	if($_POST){

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

		/* Error Handling */
		$errCount = 0;
		$_SESSION['errors'] = [];
		$generic = 'There was an error processing your request, please try again.';

		try {
			$customer = Stripe_Customer::create(array(
				"description" => "Test customer for heybenshort.co.uk",
				"card" => $stripeCard, // obtained with Stripe.js
				"plan" => $chosenPlan,
				"email" => $email
			));
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

		if($errCount === 0) {

			$success = false;
			$link = mysqliconn();

			$highestID = get_highest_shop_id();
			printr($highestID);
			$ID = ($highestID + 1);

			$userSQL = 'INSERT INTO `users_table` VALUES
			(
				NULL,
				"'. mysqli_real_escape_string($link,$name) .'",
				"'. mysqli_real_escape_string($link,$username) .'",
				"'. mysqli_real_escape_string($link,$password) .'",
				"'. mysqli_real_escape_string($link,$email) .'",
				"'. mysqli_real_escape_string($link,$customer->id) .'",
				"3",
				"'.$ID.'"
			)';


			if($result = $link->query($userSQL)){
				$managerID = ($link->insert_id);
				//shopName, shopAddress, shopCity, shopCounty, shopPostCode
				$shopSQL = 'INSERT INTO `shop_table` VALUES
				(
					"'. mysqli_real_escape_string($link,$shopName).'",
					"'. mysqli_real_escape_string($link,$shopAddress) .'",
					"'. mysqli_real_escape_string($link,$shopCity) .'",
					"'. mysqli_real_escape_string($link,$shopCounty) .'",
					"'. mysqli_real_escape_string($link,$shopPostCode) .'",
					"'. $ID .'",
					"'. $managerID .'"
				)';

				if($result = $link->query($shopSQL)){
					$success = true;
				} else {
					die('There was an error running the shopSQL query [' . $link->error . ']');
				}
			} else {
				die('There was an error running the userSQL query [' . $link->error . ']');
			}

			$link->close();

			if($success === true){
				header('Location: /index.php?s=y');
				exit();
			} else {
				// array_push($_SESSION['errors'], 'Sorry, There seems to be an issue with the Database, Please try again and if it continues please contact me ASAP!');
				// header('Location: index.php?e=1');
				// exit();
			}

		} else {
			header('Location: index.php?e=1');
			exit();
		}
	}
?>