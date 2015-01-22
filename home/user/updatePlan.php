<?php
	require_once '../../funcs/init.php';
	require_once '../../includes/stripe/Stripe.php';
	Stripe::setApiKey("sk_test_0Sxn7xNw7OiqzZOIQZc9B7uM");



	if($_POST){

		$customer = Stripe_Customer::retrieve($_POST['stripeID']);
		$subscription = $customer->subscriptions->retrieve($customer->subscriptions->data[0]->id);

		$errCount = 0;
		$_SESSION['errors'] = [];
		$generic = 'There was an error processing your request, please try again.';
		$newPlan = $_POST['plan'];
		$canceled = false;

		if($newPlan !== 'cancel'){
				try {
					//set new subscription and save it
					$subscription->plan = $_POST['plan'];
					$subscription->save();
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

		} else {

			$canceledPlan = $subscription->cancel();

			if($canceledPlan->status == 'canceled'){

				$link = mysqliconn();

				$sql = "UPDATE `users_table` SET `user_level` = -1 WHERE `id` = $_SESSION[userid]";

				if($result = $link->query($sql)){
					$canceled = true;
				} else {
					die('There was an error running the set inactive user query [' . $link->error . ']');
				}

				$link->close();
			} else {
				$errCount++;
				array_push($_SESSION['errors'], "Sorry, We were unable to cancel your plan! Please try again.");
			}
		}

		/* Redirects */
		if($errCount > 0){
			header('Location: index.php?e=1');
			exit();
		} else {
			if($canceled === true){
				header('Location: ../../logout.php');
				exit();
			} else {
				header('Location: index.php?s=1');
				exit();
			}
		}
	}
?>