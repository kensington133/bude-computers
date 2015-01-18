<?php

function is_loggedin() {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	} else {
		return ctype_digit($_SESSION['userid']);
	}
}

function get_lastjob($id) {
	$link = mysqliconn();

	$sql = "SELECT `product_name`,`job_notes`,`job_description`,`urgency` FROM `job_table` WHERE `job_number`= $id";

	if(!$result = $link->query($sql)) die('There was an error running the get_lastjob query [' . $link->error . ']');

	while ($row = $result->fetch_assoc()) {
		$data = $row;
	}

	return $data;

	$link->close();
}

function get_lastjob_alldata($id) {
	$link = mysqliconn();

	$sql = "SELECT * FROM `job_table` WHERE `job_number`= $id";

	if(!$result = $link->query($sql)) die('There was an error running the get_lastjob_alldata query [' . $link->error . ']');

	while ($row = $result->fetch_assoc())
	{
		$data = $row;
	}

	return $data;

	$link->close();
}

function get_customer_by_id($id) {
	$link = mysqliconn();

	$sql = "SELECT `customer_name`,`customer_email`,`customer_address`,`customer_phone` FROM `customer_table` WHERE `customer_id`= $id";

	if(!$result = $link->query($sql)) die('There was an error running the get_customer_by_id query [' . $link->error . ']');

	while ($row = $result->fetch_assoc()){
		$data = $row;
	}

	return $data;

	$link->close();
}

function get_mostrecent_job() {
	$link = mysqliconn();

	$sql = "SELECT * FROM `job_table` ORDER BY `job_number` DESC LIMIT 1";

	if(!$result = $link->query($sql)) die('There was an error running the get_lastjob_bydate query [' . $link->error . ']');

	while ($row = $result->fetch_assoc())
	{
		$data = $row;
	}

	return $data;

	$link->close();
}

function get_jobby_id($id) {
	$link = mysqliconn();

	$sql = "SELECT * FROM `job_table` WHERE `job_number` = " . $id;

	if(!$result = $link->query($sql)) die('There was an error running the get_lastjob_bydate query [' . $link->error . ']');

	while ($row = $result->fetch_assoc())
	{
		$data = $row;
	}

	return $data;

	$link->close();
}

function nice_date($date, $format = '') {
	if(!empty($date)) {
		if(empty($format)){
			return date('d/m/Y', strtotime($date));
		} else {
			return date($format, strtotime($date));
		}
	}
	else {
		return 'n/a';
	}
}

function get_jobid_range() {
	$link = mysqliconn();

	$sql = "SELECT MIN(`job_number`) AS min, MAX(`job_number`) AS max FROM `job_table`";

	if(!$result = $link->query($sql)) die('There was an error running the get_jobid_range() query [' . $link->error . ']');

	while ($row = $result->fetch_assoc())
	{
		$data = $row;
	}

	return $data;
	$link->close();
}

function search($search) {
	$link = mysqliconn();

	$searchterms = explode(' ', $search);
	$columns = array(
		'contact_name',
		'contact_address',
		'contact_phone',
		'contact_email',
		'product_name',
		'date_submitted',
		'work_done',
		'parts_used',
		'job_price',
		'last_updated'
	);

		$i = 0;
		$sql = "SELECT `job_number`,`contact_name`,`date_submitted` FROM `job_table`";

		foreach ($columns as $column) {
			$i++;
			if($i === 1){
				$sql .= " WHERE `$column` LIKE '%$search%' ";
			} else {
				$sql .= " OR `$column` LIKE '%$search%' ";
			}
		}

		$sql .= "ORDER BY `job_number` ASC";

		if(!$result = $link->query($sql)) die('There was an error running the first search query [' . $link->error . ']');

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

		return $data;

	$link->close();
}

function getAllJobIDs() {
	$link = mysqliconn();
	$sql = "SELECT `job_number` FROM `job_table`";

	if(!$result = $link->query($sql)) die('There was an error running the getAllJobIDs query [' . $link->error . ']');

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

	return $data;

	$link->close();
}

function printr($array) {
	echo "<pre>".print_r($array,true)."</pre>";
}

function get_job_list($limit = 10, $offset) {
	$link = mysqliconn();
	$sql = "SELECT `customer_id`,`job_number`,`date_submitted` FROM `job_table` ORDER BY `date_submitted` DESC, `time_submitted` DESC LIMIT $limit OFFSET $offset";

	if(!$result = $link->query($sql)) die('There was an error running the get_job_list query [' . $link->error . ']');

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

	return $data;

	$link->close();
}

function get_jobtime_by_id($id) {
	$link = mysqliconn();

	$sql = "SELECT `date_submitted`,`time_submitted` FROM `job_table` WHERE `job_number`= $id";

	if(!$result = $link->query($sql)) die('There was an error running the get_jobtime_by_id query [' . $link->error . ']');

	while ($row = $result->fetch_assoc()) {
		$data = $row;
	}

	return $data;

	$link->close();
}

function get_job_report_data($limit = 10, $offset) {
	$link = mysqliconn();

	$sql = "SELECT
	CONCAT(`job_table`.`date_submitted`, ' ', `job_table`.`time_submitted`) AS 'datetime_submitted',
	`job_table`.`job_number`,
	`job_table`.`progress`,
	`customer_table`.`customer_name`
	FROM `job_table`
	LEFT JOIN `customer_table`
	ON `job_table`.`customer_id` = `customer_table`.`customer_id`
	ORDER BY `date_submitted` DESC, `time_submitted` DESC
	LIMIT $limit
	OFFSET $offset";

	if(!$result = $link->query($sql)) die('There was an error running the get_job_report_data query [' . $link->error . ']');

	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}

	return $data;

	$link->close();
}

function output_job_card($jobData, $customerData){
	echo "<div class='panel' style='overflow: hidden;'>";
		echo "<div class='large-10 medium-10 columns'>";
			echo "<h5>".ucwords($customerData['customer_name'])." - ". date('l jS \of F Y', strtotime($jobData['date_submitted']))."</h5>";
			echo "<a href='/home/jobs/index.php?id=".$jobData['job_number']."'>View Job &raquo;</a>";
		echo "</div>";
		if($customerData['customer_phone']){
			echo "<div class='large-2 medium-2 columns'>";
				echo "<a class='button tiny' style='margin-top: 10px;' href='tel:".$customerData['customer_phone']."'>Call: ".$customerData['customer_phone']."</a>";
			echo "</div>";
		}
	echo "</div>";
}

function get_graph_data(){
	$link = mysqliconn();

	$sql = "SELECT CONCAT(`date_submitted`, ' ', `time_submitted`) AS `date` FROM `job_table`";

	if(!$result = $link->query($sql)) die('There was an error running the get_graph_data query [' . $link->error . ']');

	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}

	return $data;

	$link->close();
}


function create_test_data($numCreate = 10){

	if(($numCreate < 1) || ($numCreate > count($names))){

		$jobsAdded = 0;
		$customersAdded = false;

		$link = mysqliconn();

		$sql1 = "SELECT MAX(`customer_id`) AS `id` FROM `customer_table`";
		$result1 = $link->query($sql1);
		while ($row = $result1->fetch_assoc()) {
			$lastID = $row;
		}

		$lastID['id'] = ($lastID['id']+1);

		$sql2 = "SELECT MAX(`job_number`) AS `max` FROM `job_table`";
		$result2 = $link->query($sql2);
		while ($row = $result2->fetch_assoc()) {
			$last = $row;
		}

		$last['max'] = ($last['max']+1);

		if(($result1->num_rows == 1) && ($result2->num_rows == 1)) {

			//id, name, email, address, phone
			$customerSQL = "INSERT INTO `customer_table` VALUES ";
			$names = ['Darcel Marinaro','Nicolasa Griffey','Ethelyn Points','Venus Valletta','Amy Vanduzer','Ludivina Irey','Tyron Shortt','Cristobal Mclin','Maynard Grabowski','Pandora Timm','Katelyn Browner','Frieda Kuchta','Rocco Coury','Minnie Frasca','Roselia Bellinger','Odelia Boulden','Xiao Damm','Erminia Swing','Cleora Leachman','Agatha Carn','Simona Shorts','Judson Arant','Lurlene Corby','Tennille Kanagy','Shavonda Mang','Jonah Allard','Alexander Whitson','Tia Hudak','Son Winward','Chana Hurtado','Merideth Bulloch','Woodrow Darner','Lucinda Berrey','Georgetta Aguila','Carry Jamal','Joannie Bowser','Lucina Whang','Arianne Ensminger','Eugena Koerber','Delmy Cantu','Allie Testa','Matthew Townsley','Micaela Montenegro','Velma Gauvin','Diedra Wiener','Leontine Predmore','Misha Ladouceur','Santa Mckee','Frederica Wentworth','Leo Aye'];

			for($i = 1; $i <= $numCreate; $i++){
				$randName = $names[rand($i, (count($names)-1))];
				$phoneNumber = substr(number_format(time() * mt_rand(), 0, '', ''), 0, 10);
				$email = str_replace(' ', '.', strtolower($randName)).'@gmail.com';
				$customerID = $lastID['id']++;

				if($i == $numCreate){
					$customerSQL .= "('$customerID', '$randName', '$email', 'House Name, Road, Village, City, AA111AA', '$phoneNumber')\n";
				} else {
					$customerSQL .= "('$customerID', '$randName', '$email', 'House Name, Road, Village, City, AA111AA', '$phoneNumber'),\n";
				}

				$curDate = new DateTime();
				$curUnix = $curDate->format('U');
				$curMonth = $curDate->format('m');
				$remainingMonths = (12 - $curMonth);
				$modify = ($remainingMonths == 1)? '+'.$remainingMonths.' Month': '+'.$remainingMonths.' Months';
				$newDate = new DateTime();
				$nextUnix = $newDate->modify($modify)->format('U');
				$lastJobID = $last['max']++;
				$randU = rand($curUnix, $nextUnix);
				$randDate = date('Y-m-d', $randU);
				$randTime = date('h:i:s', $randU);
				$curUpdate = date('Y-m-d H:i:s');
				$randProgres = rand(0, 2);
				$randUrgency = rand(1, 10);
				$yesno = ['yes', 'no'];
				$randAdditonal = $yesno[rand(0,1)];

				//`customer_id`,`product_name`, `job_number`, `job_notes`, `job_description`, `charger`, `battery`, `storage`, `date_submitted`, `time_submitted`, `work_done`, `parts_used`, `job_price`, `last_updated`, `progress`,`urgency`
				$jobSQL = "INSERT INTO `job_table` VALUES ('$customerID', 'Dummy Product $i', '$lastJobID', 'This is some dummy job notes', 'This is some dummy job description', '$randAdditonal', '$randAdditonal', '$randAdditonal', '$randDate', '$randTime', '', '', '', '$curUpdate', '$randProgres', '$randUrgency')";
				if($result = $link->query($jobSQL)) {
					$jobsAdded++;
				} else {
					die('There was an error running the create_test_data - job query [' . $link->error . ']');
				}
			}

			if($result = $link->query($customerSQL)){
				$customersAdded = true;
			} else {
				die('There was an error running the create_test_data - customer query [' . $link->error . ']');
			}

			if(($jobsAdded == $numCreate) && ($customersAdded == true)){
				echo 'Success!';
			} else {
				echo 'Fail!';
			}

			$link->close();
		}
	} else {
		echo 'Not enough names!';
	}
}

function get_job_count(){
	$link = mysqliconn();

	$sql = "SELECT COUNT(*) FROM `job_table`";

	if(!$result = $link->query($sql)) die('There was an error running the get_graph_data query [' . $link->error . ']');

	while ($row = $result->fetch_row()) {
		$data = $row[0];
	}

	return $data;

	$link->close();
}