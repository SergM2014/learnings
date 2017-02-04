<?php

namespace App\Core;

/**
 *
 * establish DB connection
 *
 * Class DataBase
 * @package App\Core
 */
class DataBase {

	protected $conn;

    function __construct(){

     try{
           $this->conn = new \PDO('mysql:dbname='.NAME_BD.';host='.HOST.'', USER, PASSWORD, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES\'UTF8\''));

        // $this->conn = new \PDO("sqlite:".NAME_BD);

        }catch(\PDOException $e) {die("Ошибка соединения с базой или хостом:".$e->getMessage());}

        $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

        if(DEBUG_MODE){
         //на время разработки
         $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
	   }

    }

}

?>
