<?php
require_once 'funcs/init.php';
unset($_SESSION['errors']);

if($_POST){
	$errors = 0;
	$_SESSION['errors'] = [];

	if("" == $_POST['amount']){
		$errors++;
		$_SESSION['errors']['empty'] = "<small class='error'>Amount can't be empty!</small>";
	} else {
		if(!ctype_digit($_POST['amount'])){
			$errors++;
			$_SESSION['errors']['text'] = "<small class='error'>Enter a number!</small>";
		} else {
			if(($_POST['amount'] < 1) || ($_POST['amount'] > 50)) {
				$errors++;
				$_SESSION['errors']['range'] = "<small class='error'>Enter a number between 1 and 50!</small>";
			}
		}
	}

	if($errors > 0) {
		header('Location: 1.php');
		exit();
	} else {
		create_test_data($_POST['amount']);
		header('Location: 1.php?s=y');
		exit();
	}
}

?>