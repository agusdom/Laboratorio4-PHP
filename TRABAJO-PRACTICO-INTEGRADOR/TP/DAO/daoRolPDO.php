<?php 
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Dao\iDaoRol as iDaoRol;
use Model\Rol as Rol;

class daoRolPDO implements iDaoRol
{
    private $connection;
    private $tableName= "rol";

    public function __construct()
    {
        $this->connection= Connection::GetInstance(); 
    }

    public function Add(Rol $Rol)
    {
        try
        {
            $parameters= array();
    
            $query= "INSERT INTO ". $this->tableName . " (name) VALUES (:name);";
            $parameters["name"]= $Rol->getName();
    
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
            $Rol= null;
            $RolList= array();

            $query= "SELECT * FROM ". $this->tableName . ";";
            $resultSet= $this->connection->Execute($query);

            foreach($resultSet as $row)
            {
                $Rol= new Rol();
                $Rol->setId($row["id"]);
                $Rol->setName($row["name"]);
                array_push($RolList, $Rol);
            }

            return $RolList; 
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetById($id)
    {
        $Rol= null;
        $parameters= array();

        $query= "SELECT * FROM ". $this->tableName. " WHERE id= :id;";
        $parameters["id"]= $id;

        $resultSet= $this->connection->Execute($query, $parameters);

        foreach($resultSet as $row)
        {
            $Rol= new Rol();
            $Rol->setId($row["id"]);
            $Rol->setName($row["name"]);
        }

        return $Rol;
    }

    public function Delete($id)
    {
        try
        {   
            $resultSet= null;
            $parameters= array();

            $query= "DELETE FROM ". $this->tableName. " WHERE id= :id;";
            $parameters["id"]= $id;

            $resultSet= $this->connection->ExecuteNonQuery($query, $parameters);
            return $resultSet;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function Modify($id, Rol $RolNew)
    {
        $rowCount= 0;
        $parameters= array();

        $query= "UPDATE ". $this->tableName . " SET name= :name, description= :description WHERE id= :idSearch;";
        
        $parameters["name"]= $RolNew->getName();
        $parameters["idSearch"]= $id;

        $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);

        return $rowCount;
    }
}


?>