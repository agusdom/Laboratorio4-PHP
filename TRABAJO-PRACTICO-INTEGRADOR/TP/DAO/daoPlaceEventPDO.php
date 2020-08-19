<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Model\PlaceEvent as PlaceEvent;
use Dao\IDaoPlaceEvent as IDaoPlaceEvent;

class daoPlaceEventPDO implements IDaoPlaceEvent
{
    private $connection;
    private $tableName= "placeEvents";

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddPlaceEvent(PlaceEvent $placeEvent)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (id, name, capacity) VALUES (:id, :name, :capacity);";
            $parameters= array();
            $parameters["id"]= $placeEvent->getId();
            $parameters["name"]= $placeEvent->getName();
            $parameters["capacity"]= $placeEvent->getCapacity();
            
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
            $placeEventList= array();

            $query= "SELECT id, name, capacity FROM ". $this->tableName .";";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $placeEvent = new PlaceEvent();
                $placeEvent->setId($row["id"]);
                $placeEvent->setName($row["name"]);
                $placeEvent->setCapacity($row["capacity"]);
               
                array_push($placeEventList, $placeEvent);
            }
            return $placeEventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByPlaceEventId($id)
    {
        try
        {
            $placeEvent= null;
            $parameters= array();

            $query= "SELECT * FROM ". $this->tableName . " WHERE id= :id;";
            $parameters["id"]= $id;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $placeEvent = new PlaceEvent();
                $placeEvent->setId($row["id"]);
                $placeEvent->setName($row["name"]);
                $placeEvent->setCapacity($row["capacity"]);
            }
            return $placeEvent;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByPlaceEventName($name)
    {
        try
        {
            $placeEvent= null;
            $parameters= array();

            $query= "SELECT id, name, capacity FROM ". $this->tableName . " WHERE name= :name;";
            $parameters["name"]= $name;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $placeEvent = new PlaceEvent();
                $placeEvent->setId($row["id"]);
                $placeEvent->setName($row["name"]);
                $placeEvent->setCapacity($row["capacity"]);
            }
            return $placeEvent;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function DeletePlaceEvent($id)
    {
        try
        {
            $parameters= array();

            $query= "DELETE FROM ". $this->tableName. " WHERE id= :id;";
            $parameters["id"]= $id;

            $resulSet= $this->connection->ExecuteNonQuery($query, $parameters);
            return $resulSet;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifyPlaceEvent($id, PlaceEvent $placeEventNew)
    {
        try
        {
            $parameters= array();

            $query= "UPDATE ". $this->tableName. " SET id= :idNew, name= :name, capacity= :capacity WHERE id= :idSearch;";
            
            $parameters["idNew"]= $placeEventNew->getId();
            $parameters["name"]= $placeEventNew->getName();
            $parameters["capacity"]= $placeEventNew->getCapacity();
            $parameters["idSearch"]= $id;

            $resulSet=$this->connection->ExecuteNonQuery($query, $parameters);
            return $resulSet;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>