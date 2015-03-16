<?php
class CreateJob extends db {

	private $contactName;
	private $jobDescripion;
	private $jobProduct;
	private $jobNotes;
	private $hasCharger;
	private $hasBag;
	private $hasStorage;
	private $jobUrgency;
	private $contactAddress;
	private $contactPhone;
	private $contactEmail;
	private $customerID;
	private $jobID;


	public function createNewJob($contactName, $jobDescripion, $jobProduct, $jobNotes, $hasCharger, $hasBag, $hasStorage, $jobUrgency, $contactAddress, $contactPhone, $contactEmail){

		$this->jobDescripion = $jobDescripion;
		$this->jobProduct = $jobProduct;
		$this->jobNotes = $jobNotes;
		$this->hasCharger = $hasCharger;
		$this->hasBag = $hasBag;
		$this->hasStorage = $hasStorage;
		$this->jobUrgency = $jobUrgency;
		$this->contactName = $contactName;
		$this->contactAddress = $contactAddress;
		$this->contactPhone = $contactPhone;
		$this->contactEmail = $contactEmail;

		$errors = 0;

		if(!$this->contactName){
			$errors++;
			$_SESSION['errors']['contact_name'] = "<small class='error'>A contact name is required.</small>";
		}

		if(!$this->jobDescripion){
			$errors++;
			$_SESSION['errors']['job_desc'] = "<small class='error'>A job description is required.</small>";
		}

		if($errors > 0){
			$this->errorRedirect();
		} else {
			$this->saveCustomer();
			$this->saveJob();
			$this->successRedirect();
		}
	}

	private function errorRedirect(){
		header('Location: /home/new-job/');
		exit();
	}

	private function successRedirect(){
		header('Location: done.php?s=y&jobID='.$this->jobID.'&customerID='.$this->customerID);
		exit();
	}

	private function saveCustomer(){
		$customerSQL = 'INSERT INTO `customer_table` VALUES
		(
			NULL,
			"' . mysqli_real_escape_string($this->dbLink, $this->contactName) . '",
			"' . mysqli_real_escape_string($this->dbLink, $this->contactEmail) . '",
			"' . mysqli_real_escape_string($this->dbLink, $this->contactAddress) . '",
			"' . mysqli_real_escape_string($this->dbLink, $this->contactPhone) . '"
		)';

		$this->customerID = $this->insertDataGetID($customerSQL);
	}

	private function saveJob(){

		$date = date('Y-m-d');
		$time = date('H:i:s');

		$jobSQL = 'INSERT INTO `job_table` VALUES
		(
			"'. $this->customerID .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->jobProduct) .'",
			NULL,
			"'. mysqli_real_escape_string($this->dbLink, $this->jobNotes) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->jobDescripion) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->hasCharger) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->hasBag) .'",
			"'. mysqli_real_escape_string($this->dbLink, $this->hasStorage) .'",
			"'. $date .'",
			"'. $time .'",
			"",
			"",
			"",
			NULL,
			"0",
			"'. $this->jobUrgency .'",
			"'.$_SESSION['shopID'].'"
		)';

		$this->jobID = $this->insertDataGetID($jobSQL);
	}
}
?>