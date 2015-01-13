<?php

function is_loggedin() {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		return true;
	} else {
		return isset($_SESSION['userid']);
	}
}

function get_lastjob($id) {
	$link = mysqliconn();

	$sql = "SELECT `product_name`,`job_notes`,`job_description` FROM `job_table` WHERE `job_number`= $id";

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

function nice_date($date) {
	if(!empty($date)) {
		return date('d/m/Y', strtotime($date));
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

	if(!$result = $link->query($sql)) die('There was an error running the get all job ids query [' . $link->error . ']');

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

	return $data;

	$link->close();
}

function printr($array) {
	echo "<pre>".print_r($array,true)."</pre>";
}

function getAllJobs() {
	$link = mysqliconn();
	$sql = "SELECT `customer_id`,`job_number`,`date_submitted` FROM `job_table` ORDER BY `date_submitted` DESC";

	if(!$result = $link->query($sql)) die('There was an error running the get all jobs query [' . $link->error . ']');

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}

	return $data;

	$link->close();
}