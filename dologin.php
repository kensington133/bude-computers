<?php
	require_once 'funcs/init.php';

	if($_POST){
		if(isset($_POST['uname'],$_POST['pword'])){

			$uname = $_SESSION['uname'] = $_POST['uname'];
			$pword = $_POST['pword'];
			$_SESSION['errors'] = array();

			if (empty($uname) || empty($pword)){
				$_SESSION['errors'] = 'empty';
				header('Location: index.php');
				exit();
			} else {

				$link = mysqliconn();

				$sql = "SELECT `id`, `username`, `password` FROM `users_table` WHERE `username`='". $uname ."' LIMIT 1";

				if(!$result = $link->query($sql)) die('There was an error running the user query [' . $link->error . ']');

				while ($row = $result->fetch_assoc()){
					$login_data = $row;
				}

				printr($login_data);

				if (password_verify($pword, $login_data['password'])){
					$_SESSION['userid'] = $login_data['id'];
					// header('Location: /home/');
					// exit();
				} else {
					$_SESSION['errors'] = 'fail';
					// header('Location: index.php');
					// exit();
				}

				$link->close();
			}
		}
	}
 ?>