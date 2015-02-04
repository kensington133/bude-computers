<?php
	require_once '../../php/init.php';

	$jobFeatures = new jobFeature();
	$updateJob = new UpdateJob();

	if($_POST) {

		$jobData = $jobFeatures->getUpdateJobData($_POST['job_number']);
		$customerData = $jobFeatures->getCustomerByID($jobData['customer_id']);

		if(!array_key_exists('charger', $_POST)){
			$updateJob->updateCharger($_POST['job_number']);
		}

		if(!array_key_exists('bag', $_POST)){
			$updateJob->updateBag($_POST['job_number']);
		}

		if(!array_key_exists('storage', $_POST)){
			$updateJob->updateStorage($_POST['job_number']);
		}

		$updateJob->updateJobData($jobData, $_POST);
		$updateJob->updateCustomerData($customerData, $_POST, $jobData['customer_id']);
		$updateJob->updateLastUpdateTime($_POST['job_number']);

		header('Location: index.php');
		exit();
	}
 ?>