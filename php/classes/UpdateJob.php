<?php
class UpdateJob extends db {

	public function updateCharger($jobID){
		$chargerSQL = "UPDATE `job_table` SET `charger` = 'no' WHERE `job_number` = '$jobID' AND `shop_id` = $_SESSION[shopID]";
 		return $this->updateData($chargerSQL);
	}

	public function updateBag($jobID){
		$bagSQL = "UPDATE `job_table` SET `bag` = 'no' WHERE `job_number` = '$jobID' AND `shop_id` = $_SESSION[shopID]";
 		return $this->updateData($bagSQL);
	}

	public function updateStorage($jobID){
		$storageSQL = "UPDATE `job_table` SET `storage` = 'no' WHERE `job_number` = '$jobID' AND `shop_id` = $_SESSION[shopID]";
 		return $this->updateData($storageSQL);
	}

	public function updateJobData($jobData, $post){
		foreach ($jobData as $name => $value) {
			foreach ($post as $postname => $postvalue) {
				if($postname == $name) {
					if($postvalue != $value) {

						if($postvalue === 'on'){
							$postvalue = 'yes';
						} else {
							$postvalue = mysqli_real_escape_string($this->dbLink, utf8_decode(trim($postvalue)));
						}

						$jobSQL = "UPDATE `job_table` SET `$postname` = '$postvalue' WHERE `job_number` = '$post[job_number]' AND `shop_id` = $_SESSION[shopID]";
						$this->updateData($jobSQL);

					}
				}
			}
		}
	}

	public function updateCustomerData($customerData, $post, $customerID){
		foreach ($customerData as $name => $value) {
			foreach ($post as $postname => $postvalue) {
				if($postname == $name) {
					if($postvalue != $value) {

						if($postvalue === 'on'){
							$postvalue = 'yes';
						} else {
							$postvalue = mysqli_real_escape_string($this->dbLink, utf8_decode(trim($postvalue)));
						}

						$jobSQL = "UPDATE `customer_table` SET `$postname` = '$postvalue' WHERE `customer_id` = '$customerID'";
						$this->updateData($jobSQL);

					}
				}
			}
		}
	}

	public function updateLastUpdateTime($jobID){
		$updateTimeSQL = "UPDATE `job_table` SET `last_updated` = NOW() WHERE `job_number` = '$jobID' AND `shop_id` = $_SESSION[shopID]";
		$this->updateData($updateTimeSQL);
	}
}
?>