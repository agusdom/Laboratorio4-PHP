<?php 
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Dao\iDaoCategory as iDaoCategory;
use Model\Category as Category;

class daoCategoryPDO implements iDaoCategory
{
    private $connection;
    private $tableName= "Categories";
    private $tableNameEvent= "events";
    private $tableNameCalendar= "calendars";

    public function __construct()
    {
        $this->connection= Connection::GetInstance(); 
    }

    public function AddCategory(Category $Category)
    {
        try
        {
            $parameters= array();
    
            $query= "INSERT INTO ". $this->tableName . " (name, description) VALUES (:name, :description);";
            $parameters["name"]= $Category->getName();
            $parameters["description"]= $Category->getDescription();
    
            $rowCount= $this->connection->executeNonQuery($query, $parameters);
            return $rowCount;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try
        {
            $Category= null;
            $CategoryList= array();

            $query= "SELECT id, name, description FROM ". $this->tableName . ";";
            $resultSet= $this->connection->Execute($query);

            foreach($resultSet as $row)
            {
                $Category= new Category();
                $Category->setId($row["id"]);
                $Category->setName($row["name"]);
                $Category->setDescription($row["description"]);
                array_push($CategoryList, $Category);
            }

            return $CategoryList; 
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetAllWithCalendar()
    { //devuelve todas las categorias que esten asociadas en algun calendario
        try
        {
            //SELECT DISTINCT cat.id as 'id', cat.name as 'name', cat.description as 'description' FROM categories cat INNER JOIN events e ON cat.id = e.categoryId INNER JOIN calendars cal on e.id = cal.idEvent;
            $Category= null;
            $CategoryList= array();

            $query= "SELECT DISTINCT cat.id as 'id', cat.name as 'name', cat.description as 'description' 
            FROM " .$this->tableName. " cat INNER JOIN " .$this->tableNameEvent. " e ON cat.id = e.categoryId
            INNER JOIN " .$this->tableNameCalendar. " cal on e.id = cal.idEvent;";
            $resultSet= $this->connection->Execute($query);

            foreach($resultSet as $row)
            {
                $Category= new Category();
                $Category->setId($row["id"]);
                $Category->setName($row["name"]);
                $Category->setDescription($row["description"]);
                array_push($CategoryList, $Category);
            }

            return $CategoryList; 
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByCategoryId($id)
    {
        $Category= null;
        $parameters= array();

        $query= "SELECT * FROM ". $this->tableName. " WHERE id= :id;";
        $parameters["id"]= $id;

        $resultSet= $this->connection->Execute($query, $parameters);

        foreach($resultSet as $row)
        {
            $Category= new Category();
            $Category->setId($row["id"]);
            $Category->setName($row["name"]);
            $Category->setDescription($row["description"]);
        }

        return $Category;
    }

    public function GetByCategoryName($name)
    {
        $Category= null;
        $parameters= array();

        $query= "SELECT id, name, description FROM ". $this->tableName. " WHERE name= :name;";
        $parameters["name"]= $name;

        $resultSet= $this->connection->Execute($query, $parameters);

        foreach($resultSet as $row)
        {
            $Category= new Category();
            $Category->setId($row["id"]);
            $Category->setName($row["name"]);
            $Category->setDescription($row["description"]);
        }

        return $Category;
    }

    public function DeleteCategory($id)
    {
        try
        {   
            $resultSet= null;
            $parameters= array();

            $query= "DELETE FROM ". $this->tableName. " WHERE id= :id;";
            $parameters["id"]= $id;

            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
            return $rowCount;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifyCategory($id, Category $CategoryNew)
    {
        $rowCount= 0;
        $parameters= array();

        $query= "UPDATE ". $this->tableName . " SET name= :name, description= :description WHERE id= :idSearch;";
        
        $parameters["name"]= $CategoryNew->getName();
        $parameters["description"]= $CategoryNew->getDescription();
        $parameters["idSearch"]= $id;

        $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);

        return $rowCount;
    }
}


?>

