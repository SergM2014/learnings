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


    private static $connection;

    public static function conn()
    {

        if(is_object(self::$connection))  return self::$connection;

        try{
            self::$connection = new \PDO('mysql:dbname='.NAME_BD.';host='.HOST.'', USER,
                PASSWORD, [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);

            self::$connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

            self::$connection ->exec("SET time_zone = 'Erope/Kiev'");

            if(DEBUG_MODE){
                //на время разработки
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            }

            return self::$connection;


        }catch(\PDOException $e) {die("Ошибка соединения с базой или хостом:".$e->getMessage());}


    }

    public static function getAccidentalItems(int $number, array $items)
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
