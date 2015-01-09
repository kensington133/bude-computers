<?php
//start output buffering
ob_start();
//start the session
session_start();
$_URL = "http://dev.heybenshort.co.uk";
$_LOGO = "/img/logosupersmall.jpg";
date_default_timezone_set('Europe/London');
//include critical files

ini_set('display_errors',1);
error_reporting(E_ALL ^ E_NOTICE);

//database connection info`
include 'config.php';
//user releted funcs
include	'user.funcs.php';