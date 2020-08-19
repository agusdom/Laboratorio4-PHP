<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Model\Artist as artist;
use Dao\iDaoArtist as iDaoArtist;
use Model\Photo as Photo;

class daoArtistPDO implements iDaoArtist
{
    private $connection;
    private $tableName= "artists";
    private $tableNameArtistxCalendar= "artistsxCalendars";

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddArtist(artist $artist)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (id, name, lastName, artisticName, picture) VALUES (:id, :name, :lastName, :artisticName, :picture);";
            $parameters= array();
            $parameters["id"]= $artist->getId();
            $parameters["name"]= $artist->getName();
            $parameters["lastName"]= $artist->getLastName();
            $parameters["artisticName"]= $artist->getArtisticName();
            $oPhoto= $artist->getPhoto();
            $parameters["picture"]= $oPhoto->getPath();
           
            
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
            $artistList= array();

            $query= "SELECT id , name , lastName , artisticName, picture FROM ". $this->tableName .";";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $artist = new artist();
                $artist->setId($row["id"]);
                $artist->setName($row["name"]);
                $artist->setLastName($row["lastName"]);
                $artist->setArtisticName($row["artisticName"]);
                
                $oPhoto= new Photo();
                $oPhoto->setPath($row["picture"]);
                $artist->setPhoto($oPhoto);
               
                array_push($artistList, $artist);
            }
            return $artistList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetArtistWithCalendar()  
    { //devuelve una lista de artistas que estan relacionados en algun calendario
        try
        {
            //SELECT DISTINCT a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture' FROM artists a INNER JOIN artistsxcalendars ac on a.id= ac.idArtist; 
            $artistList= array();

            $query= "SELECT DISTINCT a.id as 'id', a.name as 'name', a.lastName as 'lastName', a.artisticName as 'artisticName', a.picture as 'picture' FROM " .$this->tableName." a 
            INNER JOIN ".$this->tableNameArtistxCalendar. " ac on a.id= ac.idArtist; ";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $artist = new artist();
                $artist->setId($row["id"]);
                $artist->setName($row["name"]);
                $artist->setLastName($row["lastName"]);
                $artist->setArtisticName($row["artisticName"]);
                
                $oPhoto= new Photo();
                $oPhoto->setPath($row["picture"]);
                $artist->setPhoto($oPhoto);
               
                array_push($artistList, $artist);
            }
            return $artistList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByArtistId($id)
    {
        try
        {
            $artist= null;
            $parameters= array();

            $query= "SELECT * FROM ". $this->tableName . " WHERE id= :id;";
            $parameters["id"]= $id;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $artist = new artist();
                $artist->setId($row["id"]);
                $artist->setName($row["name"]);
                $artist->setLastName($row["lastName"]);
                $artist->setArtisticName($row["artisticName"]);
                
                $oPhoto= new Photo();
                $oPhoto->setPath($row["picture"]);
                $artist->setPhoto($oPhoto);
            }
            return $artist;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByArtisticName($artisticName)
    {
        try
        {
            $artist= null;
            $parameters= array();

            $query= "SELECT * FROM ". $this->tableName . " WHERE artisticName= :artisticName;";
            $parameters["artisticName"]= $artisticName;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {   
                $artist = new artist();
                $artist->setId($row["id"]);
                $artist->setName($row["name"]);
                $artist->setLastName($row["lastName"]);
                $artist->setArtisticName($row["artisticName"]);
                
                $oPhoto= new Photo();
                $oPhoto->setPath($row["picture"]);
                $artist->setPhoto($oPhoto);
            }
            return $artist;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function DeleteArtist($id)
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

    public function Modifyartist($id, artist $artistNew)
    {
        try
        {
            $parameters= array();

            $query= "UPDATE ". $this->tableName. " SET id= :idNew, name= :name, lastName= :lastName, artisticName= :artisticName, picture= :picture WHERE id= :idSearch;";
            
            $parameters["idNew"]= $artistNew->getId();
            $parameters["name"]= $artistNew->getName();
            $parameters["lastName"]= $artistNew->getLastName();
            $parameters["artisticName"]= $artistNew->getArtisticName();
            $oPhoto= $artistNew->getPhoto();
            $parameters["picture"]= $oPhoto->getPath();
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