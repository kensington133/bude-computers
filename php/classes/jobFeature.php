<?php
class jobFeature extends db {

	/*
	*	(int|string) $id - ID number of the job
	*	(bool) $getAll - flag to retrieve all or one job
	*/
	public function getJobByID($id, $getAll = false){
		$sql = "SELECT ";

		if($getAll === true){
			$sql .= "* ";
		} else {
			$sql .= "`customer_table`.`customer_name`,`customer_table`.`customer_email`,`customer_table`.`customer_address`,`customer_table`.`customer_phone`,`job_table`.`product_name`,`job_table`.`job_notes`,`job_table`.`job_description`,`job_table`.`urgency`,`job_table`.`date_submitted`,`job_table`.`time_submitted`";
		}

		$sql .= "FROM `job_table` LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE `job_table`.`job_number` = '". $id ."' LIMIT 1";

		return $this->getSingleRow($sql);
	}

	public function getMostRecentJob(){
		$sql = "SELECT * FROM `job_table`
		LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE `job_number` = (SELECT `job_number` FROM `job_table` WHERE `shop_id` = '$_SESSION[shopID]' ORDER BY CONCAT(`job_table`.`date_submitted`, ' ', `job_table`.`time_submitted`) DESC LIMIT 1) AND `job_table`.`shop_id` = '$_SESSION[shopID]' LIMIT 1";

		return $this->getSingleRow($sql);
	}

	/*
	*	(array) $search - array of search terms
	*/
	public function jobSearch($search){
		$searchterms = explode(' ', $search);
		$datesToSearch = [];
		$termsToSearch = [];

		$textColumns = [
			'job_number',
			'customer_name',
			'customer_address',
			'customer_phone',
			'customer_email',
			'product_name',
			'work_done',
			'parts_used'
		];

		$dateColumns = [
			'date_submitted',
			'time_submitted',
			'last_updated'
		];

		foreach ($searchterms as $term) {
			/*
				change `/` to `-` as 11/12/15
				12 November, 2015 for Americans
				11th December 2015 for everyone else
			*/
			$updated = str_replace('/', '-', $term);

			if(strtotime($updated) !== false){
				$date = new DateTime($updated);
				$timeStamp = $date->format('Y-m-d');
				array_push($datesToSearch, $timeStamp);
			} else {
				array_push($termsToSearch, $term);
			}
		}

		if(count($termsToSearch) > 0){

			$textSQL = "SELECT `job_table`.`job_number`, `customer_table`.`customer_name`, `job_table`.`date_submitted`
					FROM `job_table`
					LEFT JOIN `customer_table`
					ON `job_table`.`customer_id` = `customer_table`.`customer_id`";
			$i = 0;
			foreach ($textColumns as $column) {
				foreach($termsToSearch as $term){

					if($i === 0){
						$textSQL .= " WHERE `$column` LIKE '%$term%' ";
					} else {
						$textSQL .= "OR `$column` LIKE '%$term%' ";
					}
					$i++;
				}

			}

			$textSQL .= "ORDER BY `job_number` ASC";

			$data1 = $this->fetchAssoc($textSQL);

		}

		if(count($datesToSearch) > 0){
			$dateSQL = "SELECT `job_table`.`job_number`, `customer_table`.`customer_name`, `job_table`.`date_submitted`
					FROM `job_table`
						LEFT JOIN `customer_table`
						ON `job_table`.`customer_id` = `customer_table`.`customer_id`";
					$z = 0;
					foreach ($dateColumns as $column) {
						foreach($datesToSearch as $date) {
							if($z === 0){
								$dateSQL .= " WHERE `$column` LIKE '%$date%' ";
							} else {
								$dateSQL .= "OR `$column` LIKE '%$date%' ";
							}
							$z++;
						}
					}

			$data2 = $this->fetchAssoc($dateSQL);
		}

		if((count($data1) > 0) && (count($data2) > 0)){
			$data = $data1 + $data2;
		} else {
			if(count($data1) > 0){
				$data = $data1;
			} else {
				if(count($data2) > 0) {
					$data = $data2;
				}
			}

		}

		return $data;
	}

	public function getAllJobIDs() {
		$sql = "SELECT `job_number` FROM `job_table` WHERE `shop_id` = $_SESSION[shopID]";
		return $this->getFirstRowItems($sql);
	}

	/*
	*	(int) $limit - amount of jobs to retrieve
	*	(int) $offset - job at which to start at
	*/
	public function getJobListPage($limit = 10, $offset){
		$sql = "SELECT
		`job_table`.`customer_id`,
		`job_table`.`job_number`,
		`job_table`.`date_submitted`,
		`customer_table`.`customer_name`,
		`customer_table`.`customer_phone`
		FROM `job_table`
		LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE `job_table`.`shop_id` = $_SESSION[shopID]
		ORDER BY CONCAT(`job_table`.`date_submitted`, ' ', 'time_submitted') DESC LIMIT $limit OFFSET $offset";

		return $this->fetchAssoc($sql);
	}

	/*
	*	(int) $limit - amount of jobs to retrieve
	*	(int) $offset - job at which to start at
	*/
	public function getJobReportData($limit = 10, $offset){
		$sql = "SELECT
		CONCAT(`job_table`.`date_submitted`, ' ', `job_table`.`time_submitted`) AS 'datetime_submitted',
		`job_table`.`job_number`,
		`job_table`.`progress`,
		`job_table`.`urgency`,
		`customer_table`.`customer_name`
		FROM `job_table`
		LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE `job_table`.`progress` = '1' OR `job_table`.`progress` = '0' AND `job_table`.`shop_id` = $_SESSION[shopID]
		ORDER BY `job_table`.`job_number` DESC
		LIMIT $limit
		OFFSET $offset";

		return $this->fetchAssoc($sql);
	}

	public function getGraphData(){
		$sql = "SELECT CONCAT(`date_submitted`, ' ', `time_submitted`) AS `date` FROM `job_table` WHERE `shop_id` = $_SESSION[shopID]";
		return $this->fetchAssoc($sql);
	}

	public function getCurrentYearGraphData(){
		$currentYear = date('Y');
		$sql = "SELECT CONCAT(`date_submitted`, ' ', `time_submitted`) AS `date` FROM `job_table` WHERE `date_submitted` LIKE '$currentYear-%' AND `shop_id` = $_SESSION[shopID]";
		return $this->fetchAssoc($sql);
	}

	public function getJobCount(){
		$sql = "SELECT COUNT(*) FROM `job_table` WHERE `shop_id` = $_SESSION[shopID]";
		return $this->getFirstRowItem($sql);
	}

	/*
	*	(date) $start - start date range of jobs
	*	(date) $end - end date range of jobs
	*/
	public function getJobsBetweenDates($start, $end){
		$sql = "SELECT
		`customer_table`.`customer_name`,
		`job_table`.`product_name`,
		`job_table`.`job_description`,
		CONCAT(`job_table`.`date_submitted`, ' ', `job_table`.`time_submitted`) AS `datetime_submitted`,
		`job_table`.`last_updated`,
		`job_table`.`progress`,
		`job_table`.`urgency`
		FROM `job_table`
		LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE (`job_table`.`date_submitted` BETWEEN '".$start."' AND '".$end."') AND `job_table`.`shop_id` = $_SESSION[shopID]
		ORDER BY `job_table`.`urgency` DESC ";

		return $this->fetchAssoc($sql);
	}

	/*
	*	(date) $start - start date range of jobs
	*	(date) $end - end date range of jobs
	*/
	public function getUncompletedJobsBetweenDates($start, $end){
		$sql = "SELECT
		`customer_table`.`customer_name`,
		`customer_table`.`customer_phone`,
		`job_table`.`product_name`,
		`job_table`.`job_description`,
		CONCAT(`job_table`.`date_submitted`, ' ', `job_table`.`time_submitted`) AS `datetime_submitted`,
		`job_table`.`progress`,
		`job_table`.`urgency`,
		`job_table`.`job_number`
		FROM `job_table`
		LEFT JOIN `customer_table`
		ON `job_table`.`customer_id` = `customer_table`.`customer_id`
		WHERE (`job_table`.`date_submitted` BETWEEN '".$start."' AND '".$end."')
		AND `job_table`.`progress` != '2'
		AND `job_table`.`shop_id` = $_SESSION[shopID]
		ORDER BY datetime_submitted DESC ";

		return $this->fetchAssoc($sql);
	}

	/*
	*	(int|string) $id - ID of customer to retrieve
	*/
	public function getCustomerByID($id){
		$sql = "SELECT `customer_name`,`customer_email`,`customer_address`,`customer_phone` FROM `customer_table` WHERE `customer_id`= $id";
		return $this->getSingleRow($sql);
	}

	/*
	*	(int|string) $id - ID of job to retrieve
	*/
	public function getUpdateJobData($id){
		$sql = "SELECT * FROM `job_table` WHERE `job_number` = $id";
		return $this->getSingleRow($sql);
	}
}//end of class

?>