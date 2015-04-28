<?php
class Login extends db {

	private $userName;
	private $password;

	/*
	*	(string) $userName - username entered from form
	*	(string) $password - password entered from form
	*/
	public function doLogin($userName, $password){

			$this->userName =  $userName;
			$this->password = $password;

			if (empty($this->userName) || empty($this->password)){
				$_SESSION['errors'] = 'empty';
				$this->failLoginRedirect();
			} else {
				$loginData = $this->getLoginData();

				if (password_verify($this->password, $loginData['password'])){
					$_SESSION['userid'] = $loginData['id'];
					$_SESSION['userlevel'] = $loginData['user_level'];
					$_SESSION['shopID'] = $loginData['shop_id'];
					$this->successloginRedirect();
				} else {
					$_SESSION['errors'] = 'fail';
					$this->failLoginRedirect();
				}
			}
	}

	private function getLoginData(){
		$sql = "SELECT `id`, `username`, `password`,`user_level`,`shop_id` FROM `users_table` WHERE `username`='". $this->userName ."' LIMIT 1";
		return $this->getSingleRow($sql);
	}

	private function successloginRedirect(){
		header('Location: /home/');
		exit();
	}

	private function failLoginRedirect(){
		header('Location: index.php');
		exit();
	}
}//end class

?>