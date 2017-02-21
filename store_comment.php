<?php
require_once("vendor/autoload.php");
use App\Comment\Comment;
$objComment = new Comment();
$objComment->setData($_POST);
$objComment->setData($_FILES);

//use App\Utility\Utility;
//Utility::dd($_POST);

$objComment->store();

//App\Utility\Utility::redirect('single.php?no='.$_POST['thread_id']);
App\Utility\Utility::redirect($_SERVER['HTTP_REFERER']);

