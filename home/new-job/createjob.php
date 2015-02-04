<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';
	unset($_SESSION['errors']);

	$job = new Job();

	if($_POST) {

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

		$_SESSION['errors'] = [];

		$job->createNewJob($contactName, $jobDescripion, $jobProduct, $jobNotes, $hasCharger, $hasBag, $hasStorage, $jobUrgency, $contactAddress, $contactPhone, $contactEmail);
	}
 ?>