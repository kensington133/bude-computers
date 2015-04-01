<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^ E_NOTICE);

ob_start();
session_start();
date_default_timezone_set('Europe/London');
setlocale(LC_MONETARY, 'en_GB');

$_LOGO = "/img/$_SESSION[shopID]/logo.jpg";
$_PATH = $_SERVER['DOCUMENT_ROOT'];

require_once $_PATH.'/php/classes/utils.php';
require_once $_PATH.'/php/classes/db.php';
require_once $_PATH.'/php/classes/Register.php';
require_once $_PATH.'/php/classes/Login.php';
require_once $_PATH.'/php/classes/CreateJob.php';
require_once $_PATH.'/php/classes/UpdateJob.php';
require_once $_PATH.'/php/classes/jobFeature.php';
require_once $_PATH.'/php/classes/User.php';

$utils = new Utils();
$register = new Register();
$jobFeatures = new JobFeature();
$user = new User();
