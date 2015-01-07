<?php

function mysqliconn() {

	$link = new mysqli("localhost","root","5mbf1Q2q","final-project");

	if($link->connect_errno > 0)
	{
	    die('Unable to connect to database [' . $link->connect_error . ']');
	}

	return $link;
}