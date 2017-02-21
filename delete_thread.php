<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require_once ("vendor/autoload.php");

use App\Thread\Thread;
use App\Utility\Utility;
use App\Message\Message;

$objectThread = new Thread();
$objectThread->setData($_GET);
$data = $objectThread->show();

if ($data == false) {
    Utility::redirect("index.php");
}
$status = $objectThread->isThreadAuthor($_GET['id'], $_SESSION['author_id']);

if ($status == false){
    Message::message("You Can't modified/Delete others Threads");
    Utility::redirect($_SERVER['HTTP_REFERER']);
}

$objectThread->delete();