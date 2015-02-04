<?php
	require_once '../php/init.php';
	$jobFeatures = new JobFeature();
	$jobData = $jobFeatures->getGraphData();
	$stats = [];
	$prevYears = 5;

	$curDate = new DateTime();
	$curYear = $curDate->format('Y');
	$stats[$curYear] = 0;

	for($i = $curYear; $i >= ($curYear-$prevYears); $i--){
		$stats[$i] = 0;
	}

	foreach ($jobData as $job) {

		$jobDate = new DateTime($job['date']);
		$jobYear = $jobDate->format('Y');
		$stats[$jobYear]++;
	}

	ksort($stats);

	header('Content-type: application/json');
	echo '[';
	foreach ($stats as $key => $value) {
		if($key == $curYear){
			echo '["'.$key.'",'.$value.']';
		} else {
			echo '["'.$key.'",'.$value.'],';
		}
	}
	echo ']';
?>