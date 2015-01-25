<?php
	if($_POST){
		printr($_POST);

		$name = $_SESSION['data']['name'] = $_POST['name'];
		$username = $_SESSION['data']['username'] = $_POST['username'];
		$email = $_SESSION['data']['email'] = $_POST['email'];
		$userLevel = $_SESSION['data']['userLevel'] = $_POST['user_level'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

		$link = mysqliconn();

		$sql = "INSERT INTO `users_table` VALUES (
			NULL,
			'".$name."',
			'".$username."',
			'".$password."',
			'".$email."',
			'n/a',
			'".$userLevel."',
			'".$_SESSION['shopID']."'
			)";

		if(!$result = $link->query($sql)) die('There was an error running the add new user query [' . $link->error . ']');

		$link->close();


	}

?>