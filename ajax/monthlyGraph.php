<?php
	require_once '../php/init.php';
	$jobFeatures = new JobFeature();
	// $jobData = $jobFeatures->getGraphData();
	$jobData = $jobFeatures->getCurrentYearGraphData();

	$stats = [
		'January' => 0,
		'February' => 0,
		'March' => 0,
		'April' => 0,
 		'May' => 0,
 		'June' => 0,
 		'July' => 0,
 		'August' => 0,
 		'September' => 0,
 		'October' => 0,
 		'November' => 0,
 		'December' => 0,
	];

	foreach ($jobData as $job) {
		$jobDate = new DateTime($job['date']);
		$jobMonth = $jobDate->format('n');

		switch($jobMonth){
			case '1':
				$stats['January']++;
			break;
			case '2':
				$stats['February']++;
			break;
			case '3':
				$stats['March']++;
			break;
			case '4':
				$stats['April']++;
			break;
			case '5':
				$stats['May']++;
			break;
			case '6':
				$stats['June']++;
			break;
			case '7':
				$stats['July']++;
			break;
			case '8':
				$stats['August']++;
			break;
			case '9':
				$stats['September']++;
			break;
			case '10':
				$stats['October']++;
			break;
			case '11':
				$stats['November']++;
			break;
			case '12':
				$stats['December']++;
			break;
		}
	}

	header('Content-type: application/json');
	echo '[ ["Jan",'. $stats['January'] .'], ["Feb",'. $stats['February'] .'], ["Mar",'. $stats['March'] .'], ["Apr",'. $stats['April'] .'], ["May",'. $stats['May'] .'], ["Jun",'. $stats['June'] .'], ["Jul",'. $stats['July'] .'], ["Aug",'. $stats['August'] .'], ["Sep",'. $stats['September'] .'], ["Oct",'. $stats['October'] .'], ["Nov",'. $stats['November'] .'], ["Dec",'. $stats['December'] .'] ]';
?>