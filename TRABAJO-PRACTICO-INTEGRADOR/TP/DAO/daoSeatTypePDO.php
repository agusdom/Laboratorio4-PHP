<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Dao\IDaoSeatType as IDaoSeatType;
use Model\SeatType as SeatType;

class DaoSeatTypePDO implements IDaoSeatType
{
    private $connection;
    private $tableName= "seatTypes";

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddSeatType(SeatType $seatType)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (typeName) VALUES (:typeName);";
            $parameters= array();
            $parameters["typeName"]= $seatType->getType();

            
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
           $seatList= array();
            
            $query= "SELECT idSeatType, typeName FROM ". $this->tableName .";";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $seat= new SeatType();
                $seat->setId($row["idSeatType"]);
                $seat->setType($row["typeName"]);
                
                array_push($seatList, $seat);
            }
            return $seatList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetBySeatTypeId($id)
    {
        try
        {
            $seat= null;
            $parameters= array();

            $query= "SELECT * FROM ". $this->tableName . " WHERE idSeatType= :idSeatType;";
            $parameters["idSeatType"]= $id;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $seat= new seatType();
                $seat->setId($row["idSeatType"]);
                $seat->setType($row["typeName"]);
            }
            return $seat;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetBySeatTypeName($typeName)
    {
        try
        {
            $seat= null;
            $parameters= array();

            $query= "SELECT * FROM ". $this->tableName . " WHERE typeName= :typeName;";
            $parameters["typeName"]= $typeName;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $seat= new seatType();
                $seat->setId($row["idSeatType"]);
                $seat->setType($row["typeName"]);
            }
            return $seat;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function DeleteSeatType($id)
    {
        try
        {
            $parameters= array();
            
            //DELETE FROM seattypes WHERE idSeatType= 1;
            $query= "DELETE FROM ". $this->tableName. " WHERE idSeatType= :idSeatType;";
            $parameters["idSeatType"]= $id;

            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
            return $rowCount;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifySeatType($id, SeatType $seatTypeNew)
    {
        try
        {
            $parameters= array();

            $query= "UPDATE ". $this->tableName. " SET idSeatType= :idSeatType, typeName= :typeName WHERE idSeatType= :idSeatTypeSearch;";
            
            $parameters["idSeatType"]= $seatTypeNew->getId();
            $parameters["typeName"]= $seatTypeNew->getType();
            $parameters["idSeatTypeSearch"]= $id;

            $rowCount=$this->connection->ExecuteNonQuery($query, $parameters);
            return $rowCount;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>