<?php
	require_once '../../php/init.php';
	unset($_SESSION['errors']);

	if($_POST) {

		printr($_POST);

		$name = $_SESSION['contact_name'] = $_POST['contact_name'];
		$desc = $_SESSION['job_description'] = $_POST['job_description'];
		$urgency = $_SESSION['urgency'] = $_POST['urgency'];
		$address = (empty($_POST['contact_address'])) ? '' : $_POST['contact_address'];
		$phone = (empty($_POST['contact_phone'])) ? '' : $_POST['contact_phone'];
		$email = (empty($_POST['contact_email'])) ? '' : $_POST['contact_email'];
		$product = (empty($_POST['product_name'])) ? '' : $_POST['product_name'];
		$notes = (empty($_POST['product_notes'])) ? '' : $_POST['product_notes'];
		$charger = ($_POST['charger'] == 'on')? 'yes' : 'no';
		$bag = ($_POST['bag'] == 'on')? 'yes' : 'no';
		$storage = ($_POST['storage'] == 'on')? 'yes' : 'no';

		$errors = 0;
		$_SESSION['errors'] = array();
		if(empty($name)) {
			$errors++;
			$_SESSION['errors']['contact_name'] = "<small class='error'>A contact name is required.</small>";
		}
		if(empty($_POST['job_description'])) {
			$errors ++;
			$_SESSION['errors']['job_desc'] = "<small class='error'>A job description is required.</small>";
		}

		if($errors > 0) {
			header('Location: index.php');
			exit();
		} else {

			$link = mysqliconn();
			$date = date('Y-m-d');
			$time = date('H:i:s');

			$customerSQL = 'INSERT INTO `customer_table` VALUES
			(
				NULL,
				"' . mysqli_real_escape_string($link,$name) . '",
				"' . mysqli_real_escape_string($link,$email) . '",
				"' . mysqli_real_escape_string($link,$address) . '",
				"' . mysqli_real_escape_string($link,$phone) . '"
			)';

	 		if($result = $link->query($customerSQL)) {

	 			$customerID = ($link->insert_id);

	 			$jobSQL = 'INSERT INTO `job_table` VALUES
				(
					"'. $customerID .'",
					"'. mysqli_real_escape_string($link,$product) .'",
					NULL,
					"'. mysqli_real_escape_string($link,$notes) .'",
					"'. mysqli_real_escape_string($link,$desc) .'",
					"'. mysqli_real_escape_string($link,$charger) .'",
					"'. mysqli_real_escape_string($link,$bag) .'",
					"'. mysqli_real_escape_string($link,$storage) .'",
					"'. $date .'",
					"'. $time .'",
					"",
					"",
					"",
					NULL,
					"0",
					"'. $urgency .'"
				)';

				if(!$result = $link->query($jobSQL)) die('There was an error running the create job query [' . $link->error . ']');
				$jobID = ($link->insert_id);

	 		} else {
	 			die('There was an error running the create customer query [' . $link->error . ']');
	 		}

	 		$link->close();
			header('Location: done.php?s=y&jobID='.$jobID.'&customerID='.$customerID);
			exit();
		}
	}
 ?>