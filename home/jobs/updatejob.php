<?php
	require_once '../../php/init.php';

	if($_POST) {
		$link = mysqliconn();

		$job_data = get_jobby_id($_POST['job_number']);
		$customer_data = get_customer_by_id($job_data['customer_id']);

		if(!array_key_exists('charger', $_POST)){
			$chargerSQL = "UPDATE `job_table` SET `charger` = 'no' WHERE `job_number` = '$_POST[job_number]'";

	 		if(!$result = $link->query($chargerSQL)) die("There was an error inserting job $postname data query [" . $link->error . "]");
		}

		if(!array_key_exists('bag', $_POST)){
			$bagSQL = "UPDATE `job_table` SET `bag` = 'no' WHERE `job_number` = '$_POST[job_number]'";

	 		if(!$result = $link->query($bagSQL)) die("There was an error inserting job $postname data query [" . $link->error . "]");
		}

		if(!array_key_exists('storage', $_POST)){
			$storageSQL = "UPDATE `job_table` SET `storage` = 'no' WHERE `job_number` = '$_POST[job_number]'";

	 		if(!$result = $link->query($storageSQL)) die("There was an error inserting job $postname data query [" . $link->error . "]");
		}

		foreach ($job_data as $name => $value) {
			foreach ($_POST as $postname => $postvalue) {
				if($postname == $name) {
					if($postvalue != $value) {

						if($postvalue === 'on'){
							$postvalue = 'yes';
						} else {
							$postvalue = mysqli_real_escape_string($link, utf8_decode(trim($postvalue)));
						}

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

		$updateTimeSQL = "UPDATE `job_table` SET `last_updated` = NOW() WHERE `job_number` = '$_POST[job_number]'";
		if(!$result = $link->query($updateTimeSQL)) die("There was an error updating last_update query [" . $link->error . "]");

		$link->close();

		header('Location: index.php');
		exit();
	}
 ?>