<?php
class Utils{

	public function isLoggedIn() {
		if( (!$_SESSION['userid']) || ($_SESSION['userlevel'] < 0) ){
			header('Location: /');
			exit();
		}
	}

	/*
	*	(array) $array - array to format out
	*/
	public function printr($array) {
		echo "<pre>".print_r($array,true)."</pre>";
	}

	/*
	*	(string) $data - date to format
	*	(string) $format - date format e.g. 'l jS \of F Y h:i:s A'
	*/
	public function niceDate($date, $format = '') {
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

	/*
	*	(array) $data - array of job data returned from database
 	*/
	public function printJobCard($data){
		$day = $this->niceDate($data['date_submitted'], 'D');
		switch ($day) {
			case 'Mon':
				$color = "#00dbd5";
				break;
			case 'Tue':
				$color = "#3D9996";
				break;
			case 'Wed':
				$color = "#00FF68";
				break;
			case 'Thu':
				$color = "#FF4076";
				break;
			case 'Fri':
				$color = "#CC14A4";
				break;
			case 'Sat':
				$color = "#00B1DB";
				break;
			default:
				$color = '';
				break;
		}
		echo "<div class='panel' style='overflow: hidden; background-color: ".$color.";'>";
			echo "<div class='large-10 medium-10 columns'>";
				echo "<h5 style='color: #fff;'>".ucwords($data['customer_name'])." - ". date('l jS \of F Y', strtotime($data['date_submitted']))."</h5>";
				echo "<a style='color: #fff;' href='/home/jobs/index.php?id=".$data['job_number']."'>View Job &raquo;</a>";
			echo "</div>";
			if($data['customer_phone']){
				echo "<div class='large-2 medium-2 columns'>";
					echo "<a class='button tiny' style='margin-top: 10px; color: #fff;' href='tel:".$data['customer_phone']."'>Call: ".$data['customer_phone']."</a>";
				echo "</div>";
			}
		echo "</div>";
	}
}

?>