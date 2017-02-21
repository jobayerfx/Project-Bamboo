<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require_once ("vendor/autoload.php");

use App\Thread\Thread;
$object = new Thread();
$object->setData($_POST);
$object->setData($_FILES);

$object->update();