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

	private static $savedConnection;

    public function __construct(){

        if(is_object(self::$savedConnection)) {$this->conn = self::$savedConnection; return; }

     try{
          self::$savedConnection = new \PDO('mysql:dbname='.NAME_BD.';host='.HOST.'', USER,
         PASSWORD, [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);

         self::$savedConnection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

         self::$savedConnection ->exec("SET time_zone = 'Erope/Kiev'");

         if(DEBUG_MODE){
             //на время разработки
             self::$savedConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
         }

         $this->conn = self::$savedConnection;


     }catch(\PDOException $e) {die("Ошибка соединения с базой или хостом:".$e->getMessage());}


    }

    public function getAccidentalItems(int $number, array $items)
    {
        $count = count($items);

        //if number of items is less then 12 then take the given number of items
        $takeAmount = $count >= $number? $number: $count;
        $randomKeys = array_rand($items, $takeAmount);

        $randomItems = array_filter($items, function ($key) use ($randomKeys){
            if(in_array($key, $randomKeys)) return true;
        }, ARRAY_FILTER_USE_KEY);

        return $randomItems;
    }

}

?>
