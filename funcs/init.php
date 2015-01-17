<?php
ob_start();
session_start();
date_default_timezone_set('Europe/London');

$_URL = "http://dev.heybenshort.co.uk";
$_LOGO = "/img/logosupersmall.jpg";

// ini_set('display_errors',1);
// error_reporting(E_ALL ^ E_NOTICE);

include 'config.php';
include	'user.funcs.php';