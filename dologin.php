<?php
	require_once 'php/init.php';
	unset($_SESSION['errors']);
	$login = new Login();

	if($_POST){
		if( isset($_POST['uname'], $_POST['pword']) ){

			$uname = $_SESSION['uname'] = $_POST['uname'];
			$pword = $_POST['pword'];
			$_SESSION['errors'] = [];

			$login->doLogin($uname, $pword);
		}
	}
 ?>