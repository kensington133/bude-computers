<?php
	require_once '../../funcs/init.php';

	if($_POST) {
		$link = mysqliconn();

		$job_data = get_jobby_id($_POST['job_number']);
		$customer_data = get_customer_by_id($job_data['customer_id']);

		foreach ($job_data as $name => $value) {
			foreach ($_POST as $postname => $postvalue) {

				if($postname == $name) {
					if($postvalue != $value) {
						$postvalue = mysqli_real_escape_string($link, utf8_decode(trim($postvalue)));

						$jobSQL = "UPDATE `job_table` SET `$postname` = '$postvalue' WHERE `job_number` = '$_POST[job_number]'";

				 		if(!$result = $link->query($jobSQL)) die("There was an error inserting job $postname data query [" . $link->error . "]");
					}
				}
			}
		}

		foreach ($customer_data as $name => $value) {
			foreach ($_POST as $postname => $postvalue) {

				if($postname == $name) {
					if($postvalue != $value) {
						$postvalue = mysqli_real_escape_string($link, utf8_decode(trim($postvalue)));

						$customerSQL = "UPDATE `customer_table` SET `$postname` = '$postvalue' WHERE `customer_id` = '$job_data[customer_id]'";

				 		if(!$result = $link->query($customerSQL)) die("There was an error inserting customer $postname data query [" . $link->error . "]");
					}
				}
			}
		}



		$link->close();

		header('Location: index.php');
		exit();
	}
 ?>