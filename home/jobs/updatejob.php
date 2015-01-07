<?php
	include '../../funcs/init.php';

	if($_POST)
	{
		$link = mysqliconn();

		print_r($_POST);
		$job_data = get_jobby_id($_POST['job_number']);

		foreach ($job_data as $name => $value)
		{
			foreach ($_POST as $postname => $postvalue)
			{

				if($postname == $name)
				{
					if($postvalue != $value)
					{
						$postvalue = mysqli_real_escape_string($link, utf8_decode(trim($postvalue)));

						$sql = "UPDATE `job_table` SET `$postname` = '$postvalue' WHERE `job_number` = '$_POST[job_number]'";

						// echo "<br />" . $sql . "<br />";

				 		if(!$result = $link->query($sql)) die("There was an error inserting $postname data query [" . $link->error . "]");

					}
				}
			}
		}
		$link->close();

		header('Location: index.php');
		exit();
	}

 ?>