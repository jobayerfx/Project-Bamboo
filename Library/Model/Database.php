<?php
namespace App\Model;
use PDO;
use PDOException;

class Database{

    public $DBH;
    public $host     = "localhost";
    public $dbName   = "bamboo_db";
    public $user     = "root";
    public $password = "";

    public function __construct(){
        try {
            $this->DBH = new PDO("mysql:host=$this->host;dbname=$this->dbName",$this->user,$this->password);
            //echo "connection sucessfull!<br />";
        }
        catch (PDOException $e){
            echo "Connection Failed: " . $e->getMessage();
        }
        return $this->DBH;
    }

}// end of database class

