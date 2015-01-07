<?php
	include 'funcs/init.php';

	if(is_loggedin())
	{
		echo 'Woop';
	}
	else
	{
		echo 'Boo';
	}
?>