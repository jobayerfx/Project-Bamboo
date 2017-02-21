<?php
namespace App\User;
use App\Message\Message;
use App\Utility\Utility;
use App\Model\Database as DB;
use PDO;


class User extends DB{
    public $table          = "user_table";
    public $user_name      = "";
    public $e_mail         = "";
    public $phone          = "";
    public $password       = "";
    public $temp_picture   = "";
    public $picture        = "";
    public $id             = "";
    public $e_mail_token   = "";

    public function __construct(){
        parent::__construct();
    }

    public function setData($data=array()){
        if(array_key_exists('user_name',$data)){
            $this->user_name=$data['user_name'];
        }
        if(array_key_exists('e_mail',$data)){
            $this->e_mail=$data['e_mail'];
        }
        if(array_key_exists('phone',$data)){
            $this->phone=$data['phone'];
        }
        if(array_key_exists('password',$data)){
            $this->password=md5($data['password']);
        }
        if (array_key_exists("profile_picture", $data)){
            $this->picture = $data['profile_picture']['name'];
            $this->temp_picture = $data['profile_picture']['tmp_name'];
        }
        if(array_key_exists('id',$data)){
            $this->id=$data['id'];
        }

        if(array_key_exists('e_mail_token',$data)){
            $this->e_mail_token=$data['e_mail_token'];
        }


        return $this;
    }
    


    public function store() {

        $query = "INSERT INTO `user_table` (`user_name`, `e_mail`,`phone`, `password`,  `profile_picture`, `email_verified`) 
                  VALUES (:user_name, :e_mail, :phone, :password, :profile_picture, :e_mail_token)";

        $result = $this->DBH->prepare($query);

        $result->execute(array(':user_name'=>$this->user_name,':e_mail'=>$this->e_mail, ':phone'=>$this->phone, ':password'=>$this->password,
            ':profile_picture'=>$this->picture, ':e_mail_token'=>$this->e_mail_token));
        if ($result) {
            //Message::message("Data Inserted Successfully!");
            $uploads_dir = "../../images/author/";
            $target_file = $uploads_dir . $this->picture;
            $move = move_uploaded_file($this->temp_picture, $target_file);
            if ($move) {
                Message::message("
                    <div class=\"alert alert-success\">
                                <strong>Success!</strong> Data has been stored successfully, Please check your e_mail and active your account.
                    </div>");
                return Utility::redirect($_SERVER['HTTP_REFERER']);
            }
        }else {
            Message::message("
                <div class=\"alert alert-danger\">
                            <strong>Failed!</strong> Data has not been stored successfully.
                </div>");
            return Utility::redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function change_password(){

        //$query="UPDATE `user_table` SET password` = '$this->password' WHERE `e_mail = '$this->e_mail' ";
        //$res = $this->DBH->query($query);
        $query="UPDATE `user_table` SET `password` = :password  WHERE `e_mail` = :e_mail";
        $result = $this->DBH->prepare($query);
        $res = $result->execute(array(':password'=>$this->password, ':e_mail'=>$this->e_mail));

        if($res){
            Message::message("
             <div class=\"alert alert-info\">
             <strong>Success!</strong> Password has been updated  successfully.
              </div>");
        }
        else {
            echo "Error";
        }

    }

    public function view(){
        $query="SELECT * FROM `user_table` WHERE `user_table`.`e_mail` =:e_mail";
        $result=$this->DBH->prepare($query);
        $result->execute(array(':e_mail'=>$this->e_mail));
        $row=$result->fetch(PDO::FETCH_OBJ);
        return $row;
    }// end of view()

    public function show($id){
        $query="SELECT * FROM `user_table` WHERE `user_table`.`id` =:id LIMIT 1";
        $result=$this->DBH->prepare($query);
        $result->execute(array(':id'=>$id));
        $row=$result->fetch(PDO::FETCH_OBJ);
        return $row;
    }// end of show()

    
    public function validTokenUpdate(){
        $query="UPDATE  `user_table` SET  `email_verified`='".'Yes'."' WHERE `user_table`.`e_mail` =:e_mail";
        $result=$this->DBH->prepare($query);
        $result->execute(array(':e_mail'=>$this->e_mail));

        if($result){
            Message::message("
             <div class=\"alert alert-success\">
                <strong>Success!</strong> Email verification has been successful. Please login now!
             </div>");
        }
        else {
            echo "Error";
        }
        return Utility::redirect('registration.php');
    }

}

