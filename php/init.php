<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^ E_NOTICE);

ob_start();
session_start();
date_default_timezone_set('Europe/London');
setlocale(LC_MONETARY, 'en_GB');

$_URL = "http://dev.heybenshort.co.uk";
$_LOGO = "/img/logosupersmall.jpg";
$_PATH = $_SERVER['DOCUMENT_ROOT'];
// require_once 'config.php';
// require_once 'user.funcs.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php/classes/Utils.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php/classes/db.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php/classes/Register.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php/classes/Login.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/php/classes/jobFeature.php';

$utils = new Utils();
$register = new Register();