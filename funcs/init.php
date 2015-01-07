<?php
//start output buffering
ob_start();
//start the session
session_start();
$_URL = "http://dev.heybenshort.co.uk";
$_LOGO = "/img/logosupersmall.jpg";
date_default_timezone_set('Europe/London');
//include critical files

//database connection info`
include 'config.php';
//user releted funcs
include	'user.funcs.php';