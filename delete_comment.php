<?php
if(session_status()!=PHP_SESSION_ACTIVE) session_start();
require_once ("vendor/autoload.php");

use App\Comment\Comment;
use App\Utility\Utility;
use App\Message\Message;

$objectComment = new Comment();
$objectComment->setData($_GET);
$data = $objectComment->show();

if ($data == false) {
    Utility::redirect("index.php");
}
$status = $objectComment->isCommentAuthor($_GET['no'], $_SESSION['author_id']);

if ($status == false){
    Message::message("You Can't modified/Delete others Comments");
    Utility::redirect($_SERVER['HTTP_REFERER']);
}

$objectComment->delete();