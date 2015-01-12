<?php
	require_once '../funcs/init.php';
	unset($_SESSION['errors']);

	if($_POST){

		$username = $_SESSION['username'] = $_POST['username'];
		$email = $_SESSION['email'] = $_POST['email'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$shopID = $_SESSION['shop_id'] = $_POST['shop_id'];

		$errors = 0;
		$_SESSION['errors'] = array();

		if(empty($username)) {
			$errors++;
			$_SESSION['errors']['username'] = "<small class='error'>A username is required.</small>";
		}

		if(empty($email)) {
			$errors ++;
			$_SESSION['errors']['email'] = "<small class='error'>An email is required.</small>";
		}

		if(empty($password)) {
			$errors ++;
			$_SESSION['errors']['password'] = "<small class='error'>A password is required.</small>";
		}

		if(empty($shopID)) {
			$errors ++;
			$_SESSION['errors']['shop_id'] = "<small class='error'>Your shop ID is required.</small>";
		} else {
			if(!ctype_digit($shopID)){
				$errors ++;
				$_SESSION['errors']['shop_id'] = "<small class='error'>Your shop ID must be a number.</small>";
			}
		}

		if($errors > 0) {
			header('Location: index.php');
			exit();
		} else {

			/*$cost = 10;
			$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
			$salt = sprintf("$2a$%02d$", $cost) . $salt;
			$password = crypt($_password, $salt);*/



			$link = mysqliconn();

			$sql = 'INSERT INTO `users_table` VALUES
			(
				NULL,
				"' . mysqli_real_escape_string($link,$username) . '",
				"' . mysqli_real_escape_string($link,$password) . '",
				"' . mysqli_real_escape_string($link,$email) . '",
				"' . $shopID . '"
			)';

			if(!$result = $link->query($sql)) die('There was an error running the register query [' . $link->error . ']');

			$link->close();

			header('Location: /index.php?s=y');
			exit();
		}
	}
?>