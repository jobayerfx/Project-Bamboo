<?php
namespace App\User;
if(!isset($_SESSION) )  session_start();
use App\Model\Database as DB;

class Auth extends DB{

    public $e_mail    = "";
    public $password = "";

    public function __construct(){
        parent::__construct();
    }

    public function setData($data = array()){
        if (array_key_exists('e_mail', $data)) {
            $this->e_mail = $data['e_mail'];
        }
        if (array_key_exists('password', $data)) {
            $this->password = md5($data['password']);
        }
        return $this;
    }

    public function is_exist(){

        $query="SELECT * FROM `user_table` WHERE `user_table`.`e_mail` =:e_mail";
        $result=$this->DBH->prepare($query);
        $result->execute(array(':e_mail'=>$this->e_mail));

        $count = $result->rowCount();
        if ($count > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_registered(){
        $query = "SELECT * FROM `user_table` WHERE `email_verified`='" . 'Yes' . "' AND `e_mail`=:e_mail AND `password`=:password";
        $result=$this->DBH->prepare($query);
        $result->execute(array(':e_mail'=>$this->e_mail, ':password'=>$this->password));

        $count = $result->rowCount();
        $row = $result->fetchObject();
        if ($count > 0) {
            return $row;
        } else {
            return FALSE;
        }
    }

    public function logged_in(){
        if ((array_key_exists('e_mail', $_SESSION)) && (!empty($_SESSION['e_mail']))) {
            return TRUE;
        } else {
            return FALSE;
        }
        //echo $_SESSION['e_mail'];
    }

    public function log_out(){
        $_SESSION['e_mail'] = "";
        $_SESSION['author_id'] = "";
        unset($_SESSION['e_mail']);
        unset($_SESSION['author_id']);
        return true;
    }
    public function is_loggedIn(){

    }
}

