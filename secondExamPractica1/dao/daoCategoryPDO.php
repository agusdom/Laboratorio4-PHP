<?php
namespace Dao;

use \Exception as Exception;
use Model\Category as Category;
use Dao\Connection as Connection;
use Dao\IDaoCategory as IDaoCategory;

class DaoCategoryPDO implements IDaoCategory
{
    private $tableCategory= "categories";
    private $connection;

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function GetAll()
    {
        $categoryList=array();
        $query= "SELECT categoryId, description, isActive FROM ".$this->tableCategory.";";
        

        $resulset= $this->connection->Execute($query);

        $category= null;

        foreach($resulset as $row)
        {
            $category= new Category();
            $category->setCategoryId($row["categoryId"]);
            $category->setDescription($row["description"]);
            $category->setIsActive($row["isActive"]);

            array_push($categoryList, $category);
        }
        return $categoryList;
    }


    public function GetByCategoryId($categoryId)
    {

        $query= "SELECT categoryId, description, isActive FROM ".$this->tableCategory." WHERE categoryId= :categoryId;";
        $parameters= array();
        $parameters["categoryId"]= $categoryId;

        $resulset= $this->connection->Execute($query, $parameters);

        $category= null;

        foreach($resulset as $row)
        {
            $category= new Category();
            $category->setCategoryId($row["categoryId"]);
            $category->setDescription($row["description"]);
            $category->setIsActive($row["isActive"]);
        }
        return $category;

    }
}

?>