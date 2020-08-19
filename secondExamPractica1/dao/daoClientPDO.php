<?php
namespace Dao;

use \Exception as Exception;
use Model\Category as Category;
use Model\Client as Client;
use Model\Photo as Photo;
use Dao\Connection as Connection;
use dao\QueryType as QueryType;
use Dao\IDaoClient as IDaoClient;

class DaoClientPDO implements IDaoClient
{
    private $tableClient= "clients";
    private $tableCategory= "categories";
    private $connection;

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function Add(Client $client)
    {
        $parameters= array();
        $query= "CALL Clients_Add(?,?,?,?,?,?,?);";
        //$query= "INSERT INTO ".$this->tableClient. " (categoryId, lastName, firstName , dni, email, address, picture) VALUES (:categoryId, :lastName, :firstName , :dni, :email, :address, :picture); "; 
        
        $category= $client->getcategory();
        $parameters["categoryId"]= $category->getCategoryId();
        $parameters["lastName"]= $client->getLastName();
        $parameters["firstName"]= $client->getFirstName();
        $parameters["dni"]= $client->getDni();
        $parameters["email"]= $client->getEmail();
        $parameters["address"]= $client->getaddress();
        $photo= $client->getPicture();
        $parameters["picture"]= $photo->getPath();
        
        //$rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
        $rowCount= $this->connection->ExecuteNonQuery($query, $parameters, QueryType::StoredProcedure);

        return $rowCount;
    }

   

    public function GetAll()
    {
        try
        {
            $clientList=array();

            $query= "SELECT
            cl.clientId as 'clientId', cl.categoryId as 'categoryId', cl.lastName as 'lastName',
            cl.firstName as 'firstName', cl.dni as 'dni',
            cl.email as 'email', cl.address as 'address', cl.picture as 'picture', 
            cat.description as 'description', cat.isActive as 'isActive'
            from ".$this->tableClient." cl 
            INNER JOIN ".$this->tableCategory." cat 
            on cl.categoryId= cat.categoryId;";
            

            $resulset= $this->connection->Execute($query);

            foreach($resulset as $row)
            {
                $photo= new Photo();
                $photo->setPath($row["picture"]);

                $category= new Category();
                $category->setCategoryId($row["categoryId"]);
                $category->setDescription($row["description"]);
                $category->setIsActive($row["isActive"]);

                $client= new Client();
                $client->setClientId($row["clientId"]);
                $client->setLastName($row["lastName"]);
                $client->setFirstName($row["firstName"]);
                $client->setDni($row["dni"]);
                $client->setEmail($row["email"]);
                $client->setAddress($row["address"]);
                $client->setcategory($category);
                $client->setPicture($photo);

                array_push($clientList, $client);
            }
            return $clientList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
        
    }

    public function GetByClientDni($clientDni)
    {
        try
        {
            $query= "SELECT
            cl.clientId as 'clientId', cl.categoryId as 'categoryId', cl.lastName as 'lastName',
            cl.firstName as 'firstName', cl.dni as 'dni',
            cl.email as 'email', cl.address as 'address', cl.picture as 'picture',
            cat.description as 'description', cat.isActive as 'isActive'
            from ".$this->tableClient." cl 
            INNER JOIN ".$this->tableCategory." cat 
            on cl.categoryId= cat.categoryId 
            WHERE cl.dni= :dniSearch;";
            
            $parameters= array();
            $parameters["dniSearch"]= $clientDni;

            $resulset= $this->connection->Execute($query, $parameters);
            $client= null;

            foreach($resulset as $row)
            {
                $photo= new Photo();
                $photo->setPath($row["picture"]);

                $category= new Category();
                $category->setCategoryId($row["categoryId"]);
                $category->setDescription($row["description"]);
                $category->setIsActive($row["isActive"]);

                $client= new Client();
                $client->setClientId($row["clientId"]);
                $client->setLastName($row["lastName"]);
                $client->setFirstName($row["firstName"]);
                $client->setDni($row["dni"]);
                $client->setEmail($row["email"]);
                $client->setAddress($row["address"]);
                $client->setcategory($category);
                $client->setPicture($photo);

            }
            return $client;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
        
    }
    
    public function Delete($clientDni)
    {
        try
        {
            $query= "DELETE FROM ".$this->tableClient. " WHERE dni= :dniSearch;";
            $parameters= array();
            $parameters["dniSearch"]=$clientDni;

            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);

            return $rowCount;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>