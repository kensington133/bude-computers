<?php
	require_once '../funcs/init.php';
	$job_data = get_graph_data();

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

	foreach ($job_data as $job) {
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
	echo '[ ["January",'. $stats['January'] .'], ["February",'. $stats['February'] .'], ["March",'. $stats['March'] .'], ["April",'. $stats['April'] .'], ["May",'. $stats['May'] .'], ["June",'. $stats['June'] .'], ["July",'. $stats['July'] .'], ["August",'. $stats['August'] .'], ["September",'. $stats['September'] .'], ["October",'. $stats['October'] .'], ["November",'. $stats['November'] .'], ["December",'. $stats['December'] .'] ]';
?>