<?php

namespace App\Models;

use App\Core\DataBase;

class Category extends DataBase
{

    public function getAll()
    {
        $sql= "SELECT `c`.`id`, `c`.`title`, COUNT(`s`.`id`) AS `count_series` FROM `categories` `c` LEFT JOIN `series` `s` ON `c`.`id` = `s`.`category_id` GROUP BY `c`.`id`";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetchAll();

        return $result;

    }


}