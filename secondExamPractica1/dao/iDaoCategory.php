<?php
namespace Dao;

interface IDaoCategory
{
    public function GetAll();
    public function GetByCategoryId($categoryId);
}

?>