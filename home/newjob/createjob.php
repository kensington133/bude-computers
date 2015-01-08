<?php
	require_once '../../funcs/init.php';
	unset($_SESSION['errors']);

	if($_POST) {

		$name = $_SESSION['contact_name'] = $_POST['contact_name'];
		$desc = $_SESSION['job_description'] = $_POST['job_description'];
		$address = (empty($_POST['contact_address'])) ? '' : $_POST['contact_address'];
		$phone = (empty($_POST['contact_phone'])) ? '' : $_POST['contact_phone'];
		$email = (empty($_POST['contact_email'])) ? '' : $_POST['contact_email'];
		$product = (empty($_POST['product_name'])) ? '' : $_POST['product_name'];
		$notes = (empty($_POST['product_notes'])) ? '' : $_POST['product_notes'];

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

			//two queries needed here now - one for job_table one for customer table
			$link = mysqliconn();
			$date = date('Y-m-d');
			$time = date('H:i:s');
			$sql = 'INSERT INTO job_table VALUES
			(
				"' . mysqli_real_escape_string($link,$name) . '",
				"' . mysqli_real_escape_string($link,$address) . '",
				"' . mysqli_real_escape_string($link,$phone) . '",
				"' . mysqli_real_escape_string($link,$email) . '",
				"' . mysqli_real_escape_string($link,$product) . '",
				NULL,
				"' . mysqli_real_escape_string($link,$notes) . '",
				"' . mysqli_real_escape_string($link,$desc) .'",
				"'.$date.'",
				"'.$time.'",
				"",
				"",
				"",
				NULL
			)';


	 		if(!$result = $link->query($sql)) die('There was an error running the create job query [' . $link->error . ']');

	 		$id = ($link->insert_id);

	 		$link->close();
			header('Location: done.php?s=y&id='.$id);
			exit();
		}
	}
 ?>