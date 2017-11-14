<?php
/**
 * Created by PhpStorm.
 * User: jorge
 * Date: 14/11/17
 * Time: 20:43
 */

namespace AppBundle\Tools;

use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;

class Paginator
{
    public function getPaginator($query){
        return $this->createPaginator($query);
    }

    private function createPaginator($query){
        return new DoctrinePaginator($query);
    }
}