<?php
	require_once '../funcs/init.php';
	$job_data = get_graph_data();

	$weekJobs = [];
	$curDate = new DateTime();
	$curWeek = $curDate->format('W');

	foreach ($job_data as $job) {
		$jobDate = new DateTime($job['date']);
		$jobWeek = $jobDate->format('W');

		if($curWeek == $jobWeek){
			$day = $jobDate->format('l');
			array_push($weekJobs, $day);
		}
	}

	$stats = [
		'monday' => 0,
		'tuesday' => 0,
		'wednesday' => 0,
		'thursday' => 0,
 		'friday' => 0,
 		'saturday' => 0,
 		'sunday' => 0
	];

	foreach ($weekJobs as $day) {
		switch(strtolower($day)){
			case 'monday':
				$stats['monday']++;
			break;
			case 'tuesday':
				$stats['tuesday']++;
			break;
			case 'wednesday':
				$stats['wednesday']++;
			break;
			case 'thursday':
				$stats['thursday']++;
			break;
			case 'friday':
				$stats['friday']++;
			break;
			case 'saturday':
				$stats['saturday']++;
			break;
			case 'sunday':
				$stats['sunday']++;
			break;
		}
	}

	header('Content-type: application/json');
	if(count($weekJobs) === 0){
		echo '"error"';
	} else {
		echo '[ ["Mon",'. $stats['monday'] .'], ["Tue",'. $stats['tuesday'] .'], ["Wed",'. $stats['wednesday'] .'], ["Thu",'. $stats['thursday'] .'], ["Fri",'. $stats['friday'] .'], ["Sat",'. $stats['saturday'] .'], ["Sun",'. $stats['sunday'] .'] ]';
	}

?>