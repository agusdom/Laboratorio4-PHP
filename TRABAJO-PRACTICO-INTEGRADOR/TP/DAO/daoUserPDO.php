<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Model\User as user;
use Model\Rol as Rol;
use Dao\iDaoUser as iDaoUser;

class daoUserPDO implements iDaoUser
{
    private $connection;
    private $tableName= "users";
    private $tableNameRelated= "rol";

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddUser(user $user)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (name, lastname, email, password, rolId) VALUES (:name, :lastname, :email, :password, :rolId);";
            $parameters= array();
            #$parameters["id"]= $user->getId();
            $parameters["name"]= $user->getName();
            $parameters["lastname"]= $user->getLastName();
            $parameters["email"]= $user->getEmail();
            $parameters["password"]= $user->getPassword();

            $oRol= $user->getRol();
            $parameters["rolId"]= $oRol->getId();
           
            
            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
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
            $userList= array();

            /*
            SELECT u.id as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'userRolId', r.name as 'rolName'
            FROM users u INNER JOIN rol r ON u.rolId = r.id;
            */

            $query= "SELECT u.id as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'userRolId', r.name as 'rolName'
            FROM ". $this->tableName ." u INNER JOIN " . $this->tableNameRelated. " r ON u.rolId = r.id;";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $user = new User();
                $user->setId($row["userId"]);
                $user->setName($row["userName"]);
                $user->setEmail($row["userLastName"]);
                $user->setEmail($row["userEmail"]);
                $user->setPassword($row["userPassword"]);

                $oRol= new Rol();
                $oRol->setId($row["userRolId"]);
                $oRol->setName($row["rolName"]);

                $user->setRol($oRol);
               
                array_push($userList, $user);
            }
            return $userList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByUserId($userId)
    {
        try
        {
            $query= "SELECT u.id as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'userRolId', r.name as 'rolName'
            FROM ". $this->tableName ." u INNER JOIN " . $this->tableNameRelated. " r ON u.rolId = r.id WHERE u.id= :id;";
            $parameters= array();
            $parameters["id"]= $userId;
            
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $user = new User();
                $user->setId($row["userId"]);
                $user->setName($row["userName"]);
                $user->setEmail($row["userLastName"]);
                $user->setEmail($row["userEmail"]);
                $user->setPassword($row["userPassword"]);

                $oRol= new Rol();
                $oRol->setId($row["userRolId"]);
                $oRol->setName($row["rolName"]);

                $user->setRol($oRol);
               
            }
            return $user;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetByEmail($email)
    {
        try
        {
            $user= null;
            $parameters= array();

            $query= "SELECT u.id as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'userRolId', r.name as 'rolName'
            FROM ". $this->tableName ." u INNER JOIN " . $this->tableNameRelated. " r ON u.rolId = r.id WHERE u.email= :email;";
            $parameters["email"]= $email;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $user = new User();
                $user->setId($row["userId"]);
                $user->setName($row["userName"]);
                $user->setLastName($row["userLastName"]);
                $user->setEmail($row["userEmail"]);
                $user->setPassword($row["userPassword"]);

                $oRol= new Rol();
                $oRol->setId($row["userRolId"]);
                $oRol->setName($row["rolName"]);

                $user->setRol($oRol);
            }
            return $user;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>