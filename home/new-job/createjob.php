<?php
	require_once '../../php/init.php';
	unset($_SESSION['errors']);

	$job = new CreateJob();

	if($_POST) {

		//save the values sent in the form into the session
		$contactName = $_SESSION['contact_name'] = $_POST['contact_name'];
		$jobDescripion = $_SESSION['job_description'] = $_POST['job_description'];
		$jobUrgency = $_SESSION['urgency'] = $_POST['urgency'];
		$contactAddress = (empty($_POST['contact_address'])) ? '' : $_POST['contact_address'];
		$contactPhone = (empty($_POST['contact_phone'])) ? '' : $_POST['contact_phone'];
		$contactEmail = (empty($_POST['contact_email'])) ? '' : $_POST['contact_email'];
		$jobProduct = (empty($_POST['product_name'])) ? '' : $_POST['product_name'];
		$jobNotes = (empty($_POST['product_notes'])) ? '' : $_POST['product_notes'];
		$hasCharger = ($_POST['charger'] == 'on')? 'yes' : 'no';
		$hasBag = ($_POST['bag'] == 'on')? 'yes' : 'no';
		$hasStorage = ($_POST['storage'] == 'on')? 'yes' : 'no';
		$wPassword = $_POST['w_password'];

		$_SESSION['errors'] = [];

		//send the information to the CreateJob class to be saved
		$job->createNewJob($contactName, $jobDescripion, $jobProduct, $jobNotes, $hasCharger, $hasBag, $hasStorage, $jobUrgency, $contactAddress, $contactPhone, $contactEmail, $wPassword);
	}
 ?>