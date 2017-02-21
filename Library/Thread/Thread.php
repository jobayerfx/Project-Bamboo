<?php
namespace App\Thread;
use App\Comment\Comment;
use App\Model\Database as DB;
use App\Message\Message;
use App\Utility\Utility;
use PDO;

class Thread extends DB{

    public $id;
    public $title;
    public $category;
    public $thread_body;
    public $picture;
    public $temp_picture;
    public $author_id;

    public function __construct(){
        parent::__construct();
        if (!isset($_SESSION)) session_start();
        if (isset($_SESSION["author_id"]))
            $this->author_id = $_SESSION["author_id"];
    }//End of __construct..

    public function setData($postVariableData = NULL){

        if (array_key_exists("id", $postVariableData)){
            $this->id     = $postVariableData['id'];
        }
        if (array_key_exists("no", $postVariableData)){
            $this->id     = $postVariableData['no'];
        }
        if (array_key_exists("title", $postVariableData)){
            $this->title  = $postVariableData['title'];
        }
        if (array_key_exists("category", $postVariableData)) {
            $this->category = $postVariableData['category'];
        }
        if (array_key_exists("thread_body", $postVariableData)){
            $this->thread_body = $postVariableData['thread_body'];
        }

        if (array_key_exists("image", $postVariableData)){
            $this->picture = $postVariableData['image']['name'];
            $this->temp_picture = $postVariableData['image']['tmp_name'];
        }

    }// End of setData Method

    public function store(){

        $query = "INSERT INTO thread_table (title, category, thread_body, image, author_id, time_date) VALUES (:title, :category, :thread_body, :image, :author_id, :time_date)";
        $STH = $this->DBH->prepare($query);
        $STH->bindParam(':title', $this->title);
        $STH->bindParam(':category', $this->category);
        $STH->bindParam(':thread_body', $this->thread_body);
        $STH->bindParam(':image', $this->picture);
        $STH->bindParam(':author_id', $this->author_id);
        $STH->bindParam(':time_date', time());
        $result = $STH->execute();

        if ($result){
            Message::message("Data Inserted Successfully!");
            $uploads_dir = "images/blog/";
            $target_file = $uploads_dir . $this->picture;
            $move = move_uploaded_file($this->temp_picture, $target_file);
            if ($move){
                Message::message("Your Thread Added Successfully !");
            }

        }else{
            Message::message("Your Thread insertion Fail!");
        }

        Utility::redirect('index.php');

    }//...End store() method...
    
    public function index($fetchMode='ASSOC'){
        $sql = "SELECT * FROM thread_table";
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

        if ($this->picture){
            $sql = "UPDATE `thread_table` SET `title` = '".$this->title."', `category` = '".$this->category."', `thread_body` = '".$this->thread_body."', `image` = '".$this->picture."', `time_date` = ".time()." WHERE `thread_table`.`id` = ".$this->id;
            $data = $this->show();
            $files = 'images/blog/'.$data->picture;
            unlink($files);
            $uploads_dir = "images/blog/";
            $target_file = $uploads_dir . $this->picture;
            $move = move_uploaded_file($this->temp_picture, $target_file);
            if ($move){
                Message::message("File/Image Updated Successfully");
            }

        }else{
            //$sql = "UPDATE `thread_table` SET `title` = '".$this->title."', `category` = '".$this->category."', `thread_body` = '".$this->thread_body."' WHERE `thread_table`.`id` = ".$this->id;
            $sql = "UPDATE thread_table SET title = '$this->title', category = '$this->category', thread_body = '$this->thread_body', time_date = ".time()." WHERE id = '$this->id' ";
      }

        $query = $this->DBH->prepare($sql);
        $result = $query->execute();

        if ($result && $move){
            Message::message("Data/Image Updated Successfully !");

        }elseif($result){
            Message::message("Data Updated Successefully !");
        }else{
            Message::message("Data Update Fail !");
        }
        Utility::redirect("index.php");
    }//End of Uddate() Method

    public function isThreadAuthor($thread_id, $author_id)
    {
        //$sql = "SELECT * FROM `thread_table` WHERE `id` =  '{$thread_id}' AND `author_id` =  '{$author_id}' LIMIT 1 ";
        $sql = "SELECT * FROM `thread_table` WHERE `id` = $thread_id AND `author_id` = $author_id";
        $query = $this->DBH->prepare($sql);
        $query->execute();
        return $query->fetchobject();
    }

    public function show(){
        $sql = "SELECT * FROM thread_table WHERE id = $this->id LIMIT 1 ";
        $query = $this->DBH->prepare($sql);
        $query->execute();
        return $query->fetchobject();
    } //End Show() Method...
    
    public function view($id){
        $query = $this->DBH->prepare("SELECT * FROM thread_table WHERE id = $id LIMIT 1");
        $query->execute();
        return $query->fetchObject();
    }// End of the view() Method..

    public function delete(){

        $data = $this->show();
        $files = 'images/blog/'.$data->image;
        if (file_exists($files))
            unlink($files);

        $sql = "DELETE FROM `thread_table` WHERE `thread_table`.`id` = $this->id ";
        $query = $this->DBH->prepare($sql);
        $result = $query->execute();

        if ($result){
            $objComment = new Comment();
            $comments = $objComment->index($this->id, 'obj');
            foreach ($comments as $key => $comment ){
                $objComment->id = $comment->thread_id;
                $objComment->delete();
            }
            Message::message("Thread Deleted Successfully !");
        }else{
            Message::message("Thread Delete Fail !");
        }
        Utility::redirect("index.php");
    }

    public function indexPaginator($page=0,$itemsPerPage=3){

        $start = (($page-1) * $itemsPerPage);

        $sql = "SELECT * from thread_table LIMIT $start,$itemsPerPage";

        $STH = $this->DBH->query($sql);

        $STH->setFetchMode(PDO::FETCH_OBJ);

        $arrSomeData  = $STH->fetchAll();
        return $arrSomeData;

    }// end of indexPaginator();

    public function search($requestArray){
        $sql = "SELECT * FROM `thread_table` WHERE (`title` LIKE '%".$requestArray['search']."%' OR `thread_body` LIKE '%".$requestArray['search']."%' OR `category` LIKE '%".$requestArray['search']."%')";
        //if(isset($requestArray['byName']) && !isset($requestArray['byAge']) ) $sql = "SELECT * FROM `thread_table` WHERE `deleted_at` IS NULL AND `title` LIKE '%".$requestArray['search']."%'";
        //if(!isset($requestArray['byName']) && isset($requestArray['byAge']) )  $sql = "SELECT * FROM `thread_table` WHERE `deleted_at` IS NULL AND `category` LIKE '%".$requestArray['search']."%'";

        if ($sql != "") {
            $STH = $this->DBH->query($sql);
            $STH->setFetchMode(PDO::FETCH_OBJ);
            $allData = $STH->fetchAll();
            return $allData;
        }else {
            Message::message("Sorry! No Item found!");
            return array();
        }
    }// end of search()



    public function getAllKeywords()
    {
        $_allKeywords = array();
        $WordsArr = array();
        $sql = "SELECT * FROM `thread_table`";

        $STH = $this->DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);

        // for each search field block start
        $allData = $STH->fetchAll();
        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->title);
        }

        $STH = $this->DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);

        $allData= $STH->fetchAll();
        foreach ($allData as $oneData) {

            $eachString = strip_tags($oneData->title);
            $eachString = trim( $eachString);
            $eachString = preg_replace( "/\r|\n/", " ", $eachString);
            $eachString = str_replace("&nbsp;","",  $eachString);
            $WordsArr   = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end


        // for each search field block start
        $STH = $this->DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $allData= $STH->fetchAll();
        foreach ($allData as $oneData) {
            $_allKeywords[] = trim($oneData->category);
        }

        $STH = $this->DBH->query($sql);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $allData= $STH->fetchAll();
        foreach ($allData as $oneData) {

            $eachString= strip_tags($oneData->category);
            $eachString=trim( $eachString);
            $eachString= preg_replace( "/\r|\n/", " ", $eachString);
            $eachString= str_replace("&nbsp;","",  $eachString);
            $WordsArr = explode(" ", $eachString);

            foreach ($WordsArr as $eachWord){
                $_allKeywords[] = trim($eachWord);
            }
        }
        // for each search field block end


        return array_unique($_allKeywords);

    }// get all keywords
}