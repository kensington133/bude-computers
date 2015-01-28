<?php
class Utils{
	public function is_loggedin() {
		if((ctype_digit($_SESSION['userid'])) && ($_SESSION['userlevel'] > 0)){
			return true;
		} else {
			return false;
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

}

?>