<?php
require_once("vendor/autoload.php");
use App\Thread\Thread;
$objThread = new Thread();
$objThread->setData($_POST);
$objThread->setData($_FILES);

//use App\Utility\Utility;
//Utility::dd($_FILES);

$objThread->store();

