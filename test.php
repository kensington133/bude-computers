<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php/init.php';

$job = new jobFeature();

$utils->printr($job->getJobByID(218));


?>