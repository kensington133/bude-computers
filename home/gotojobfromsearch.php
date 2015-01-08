<?php
	require_once '../funcs/init.php';

	if($_GET)
	{
		$job_range = get_jobid_range();
		$job_number = $_GET['job_number'];
		$max = $job_range['max'];
		$min = $job_range['min'];

		if($_POST['job_number'] != "")
		{
			if( ($job_number >= $min) && ($job_number <= $max) )
			{
				header('Location: '.$_URL.'/home/jobs/index.php?id='.$job_number);
				exit();
			}
			else
			{
				header('Location: '.$URL.'/home/index.php?e=2');
				exit();
			}
		}
		else
		{
			header('Location: '.$URL.'/home/');
			exit();
		}
	}

 ?>