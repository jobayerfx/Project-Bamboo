<?php
namespace App\Comment;
use App\Model\Database as DB;
use App\Message\Message;
use App\Utility\Utility;
use PDO;

class Comment extends DB{

    public $id;
    public $comment_body;
    public $user_name;
    public $user_email;
    public $picture;
    public $temp_picture;
    public $author_id;
    public $thread_id;

    public function __construct(){
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION["author_id"]))
            $this->author_id = $_SESSION["author_id"];
    }//End of __construct Method()..

    public function setData($postVariableData = NULL){

        if (array_key_exists("id", $postVariableData)){
            $this->id     = $postVariableData['id'];
        }
        if (array_key_exists("no", $postVariableData)){
            $this->id     = $postVariableData['no'];
        }
        if (array_key_exists("thread_id", $postVariableData)){
            $this->thread_id     = $postVariableData['thread_id'];
        }
        if (array_key_exists("comment_body", $postVariableData)){
            $this->comment_body  = $postVariableData['comment_body'];
        }
        if (array_key_exists("user_name", $postVariableData)) {
            $this->user_name = $postVariableData['user_name'];
        }
        if (array_key_exists("user_email", $postVariableData)){
            $this->user_email = $postVariableData['user_email'];
        }

        if (array_key_exists("photo", $postVariableData)){
            $this->picture = $postVariableData['photo']['name'];
            $this->temp_picture = $postVariableData['photo']['tmp_name'];
        }

    }// End of setData Method

    public function store()
    {
        //Utility::dd($this);
        date_default_timezone_set('Asia/Dhaka');
        $time = time();
        if (($this->author_id != NULL) && ($this->user_name == NULL)){
            $query = "INSERT INTO comment_table (comment_body, photo, author_id, thread_id, time_date)
                      VALUES (:comment_body, :photo, :author_id, :thread_id, :time_date)";
            $STH = $this->DBH->prepare($query);
            $STH->bindParam(':author_id', $this->author_id);
        }else{
            $query = "INSERT INTO comment_table (comment_body, photo, user_name, user_email, thread_id, time_date)
                      VALUES (:comment_body, :photo, :user_name, :user_email, :thread_id, :time_date)";
            $STH = $this->DBH->prepare($query);
            $STH->bindParam(':user_name', $this->user_name);
            $STH->bindParam(':user_email', $this->user_email);
        }
        $STH->bindParam(':comment_body', $this->comment_body);
        $STH->bindParam(':photo', $this->picture);
        $STH->bindParam(':thread_id', $this->thread_id);
        $STH->bindParam(':time_date', $time);

        $result = $STH->execute();

        if ($result && $this->picture != ""){
            Message::message("Your Comment Added Successfully!");
            $uploads_dir = "images/comment/";
            $target_file = $uploads_dir . $this->picture;
            $move = move_uploaded_file($this->temp_picture, $target_file);
            if ($move){
                Message::message("Your Comment Added Successfully !");
            }

        }elseif($result){
            Message::message("Your Comment Added Successfully...");
        }else{
            Message::message("Your Comment insertion Fail!");
        }

        //Utility::redirect('single.php?no='.$this->thread_id);

    }//...End store() method...

    public function index($id, $fetchMode='ASSOC'){
        $sql = "SELECT * FROM comment_table WHERE thread_id = '$id'";
        $STH = $this->DBH->query($sql);

        $fetchMode = strtoupper($fetchMode);
        if(substr_count($fetchMode,'OBJ') > 0)
            $STH->setFetchMode(PDO::FETCH_OBJ);
        else
            $STH->setFetchMode(PDO::FETCH_ASSOC);

        $arrAllData  = $STH->fetchAll();
        return $arrAllData;

    }// end of index();

    public function update(){

        date_default_timezone_set('Asia/Dhaka');
        $time = time();
        $uploads_dir = "images/comment/";
        if (($this->author_id != NULL) && ($this->user_name == NULL)){
            if ($this->picture){
                $sql = "UPDATE `comment_table` SET `comment_body` = '$this->comment_body', `photo` = '$this->picture',
                `time_date`= $time WHERE `id` = $this->id";
                $data = $this->show();
                $files = 'images/comment/'.$data->photo;
                unlink($files);
                $target_file = $uploads_dir . $this->picture;
                move_uploaded_file($this->temp_picture, $target_file);

            }else{
                $sql ="UPDATE `comment_table` SET `comment_body`='$this->comment_body', `time_date`= $time WHERE `id` = $this->id";
            }
        }else{
            if ($this->picture){
                $sql = "UPDATE `comment_table` SET `comment_body` = '$this->comment_body', `photo` = '$this->picture', `user_name` = '$this->user_name',
             `user_email` = '$this->user_email', `time_date`= $time WHERE `id` = $this->id";
                $data = $this->show();
                $files = 'images/comment/'.$data->photo;
                unlink($files);

                $target_file = $uploads_dir . $this->picture;
                $move = move_uploaded_file($this->temp_picture, $target_file);
                if ($move){
                    Message::message("File/Image Updated Successfully");
                }

            }else{
                $sql = "UPDATE comment_table SET `comment_body` = '$this->comment_body', `user_name` = '$this->user_name',
                `user_email` = '$this->user_email', `time_date`= $time WHERE `id` = $this->id";
            }

        }


        $query = $this->DBH->prepare($sql);
        $result = $query->execute();

        if($result){
            Message::message("Your Comment Updated Successefully !");
        }else{
            Message::message("Comment Update Fail !");
        }
        Utility::redirect($_SERVER['HTTP_REFERER']);
    }//End of Uddate() Method..
    
    public function isCommentAuthor($comment_id, $author_id)
    {
        $sql = "SELECT * FROM `comment_table` WHERE `id` = $comment_id AND `author_id` = $author_id LIMIT 1";
        $query = $this->DBH->prepare($sql);
        $query->execute();
        return $query->fetchobject();
    }

    public function show(){
        $sql = "SELECT * FROM comment_table WHERE id = $this->id LIMIT 1 ";
        $query = $this->DBH->prepare($sql);
        $query->execute();
        return $query->fetchobject();
    } //End Show() Method...

    public function view(){
        $query = $this->DBH->prepare("SELECT * FROM comment_table ORDER BY id DESC ");
        $query->execute();
        return $query->fetchAll();
    }// End of the view() Method..

    public function delete()
    {
        $data = $this->show();
        $files = 'images/comment/'.$data->photo;
        if (file_exists($files))
            unlink($files);

        $sql = "DELETE FROM `comment_table` WHERE `comment_table`.`id` = $this->id ";
        $query = $this->DBH->prepare($sql);
        $result = $query->execute();

        if ($result){
            Message::message("Data Deleted Successfully !");
        }else{
            Message::message("Data Delete Fail !");
        }
        Utility::redirect($_SERVER['HTTP_REFERER']);
    }
    
}//End Comment Class