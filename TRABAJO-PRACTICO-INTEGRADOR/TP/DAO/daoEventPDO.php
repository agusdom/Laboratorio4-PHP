<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Model\event as event;
use Model\category as category;
use Model\Photo as Photo;
use Dao\iDaoevent as iDaoevent;

class daoeventPDO implements iDaoevent
{
    private $connection;
    private $tableName= "events";
    private $tableNameCategory= "categories";
    private $tableNameCalendar= "calendars";
    private $tableNameArtistxCalendar= "artistsxCalendars";

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function Addevent(event $event)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (name, categoryId, picture) VALUES (:name, :categoryId, :picture);";
            $parameters= array();
            $parameters["name"]= $event->getName();
            $ocategory= $event->getCategory();
            $parameters["categoryId"]= $ocategory->getId();
            $ophoto= $event->getPhoto();
            $parameters["picture"]= $ophoto->getPath();
            
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
            $eventList= array();
            
            $query= "SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description' FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id ORDER BY e.id;";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);

                
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetAllByDate()
    {//devuelve todos los eventos ordenados por fecha
        try
        {
            $eventList= array();
            /*
            SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description', cal.dateCalendar as 'calendarDate'
            FROM events e INNER JOIN categories c ON e.categoryId = c.id 
            INNER JOIN calendars cal ON e.id = cal.idEvent ORDER BY cal.dateCalendar;
            */
            $query= "SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description', cal.dateCalendar as 'calendarDate'
             FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id 
             INNER JOIN " . $this->tableNameCalendar. " cal ON e.id = cal.idEvent ORDER BY cal.dateCalendar;";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);

                
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByBetweenDates($date1= "", $date2= "")
    {//devuelve todos los eventos ordenados por fecha
        try
        {
            $eventList= array();
            $parameters= array();
            /*
            SELECT
            e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description', cal.dateCalendar as 'calendarDate'
            FROM events e 
            INNER JOIN categories c ON e.categoryId = c.id 
            INNER JOIN calendars cal ON e.id = cal.idEvent 
            WHERE cal.dateCalendar >= '2018-11-26';
            */
            if(($date1 != "") && ($date2 != ""))
            {
                $query= "SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description'
                FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id 
                INNER JOIN " . $this->tableNameCalendar. " cal ON e.id = cal.idEvent
                WHERE (cal.dateCalendar BETWEEN :date1 AND :date2);";

                $parameters["date1"]= $date1;
                $parameters["date2"]= $date2;
            }
            elseif(($date1 != "") && ($date2 == ""))
            {
                $query= "SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description'
                FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id 
                INNER JOIN " . $this->tableNameCalendar. " cal ON e.id = cal.idEvent
                WHERE (cal.dateCalendar >= :date1);";

                $parameters["date1"]= $date1;
            }
            elseif(($date1 == "") && ($date2 != ""))
            {
                $query= "SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description'
                FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id 
                INNER JOIN " . $this->tableNameCalendar. " cal ON e.id = cal.idEvent
                WHERE (cal.dateCalendar <= :date2);";
                $parameters["date2"]= $date2;
            }
            
            $resulSet= $this->connection->Execute($query, $parameters);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);

                
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetEventByArtistId($artistId, $date1= "", $date2= "")
    { //devuelve todos los event que estan asociados con algun artista especifico 
        //si le enviamos fecha , tambien filtra por fecha
        try
        {
            /* QUERY SIN FECHA
            SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription'  
            FROM events e 
            INNER JOIN calendars cal on e.id = cal.idEvent 
            INNER JOIN artistsxcalendars axc on cal.idCalendar = axc.idCalendar 
            INNER JOIN categories cat on e.categoryId= cat.id WHERE axc.idArtist=10;
            */
            /* QUERY CON FECHA
            SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',  
            cal.dateCalendar as 'fecha'            
            FROM events e 
            INNER JOIN calendars cal on e.id = cal.idEvent 
            INNER JOIN artistsxcalendars axc on cal.idCalendar = axc.idCalendar 
            INNER JOIN categories cat on e.categoryId= cat.id WHERE axc.idArtist=1
            AND (cal.dateCalendar BETWEEN '2018-11-26' AND '2018-11-29');
            */

            $eventList= array();
            $parameters= array();
            $parameters["idSearch"]= $artistId;
            
            if(($date1 == "") && ($date2 == ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCalendar. " cal on e.id = cal.idEvent 
                INNER JOIN " .$this->tableNameArtistxCalendar. " axc on cal.idCalendar = axc.idCalendar 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id WHERE axc.idArtist= :idSearch";
                
            }
            elseif(($date1 != "") && ($date2 != ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCalendar. " cal on e.id = cal.idEvent 
                INNER JOIN " .$this->tableNameArtistxCalendar. " axc on cal.idCalendar = axc.idCalendar 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id WHERE axc.idArtist= :idSearch
                AND (cal.dateCalendar BETWEEN :date1 AND :date2);";

                $parameters["date1"]= $date1;
                $parameters["date2"]= $date2;
            }
            elseif(($date1 != "") && ($date2 == ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCalendar. " cal on e.id = cal.idEvent 
                INNER JOIN " .$this->tableNameArtistxCalendar. " axc on cal.idCalendar = axc.idCalendar 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id WHERE axc.idArtist= :idSearch
                AND cal.dateCalendar >= :date1;";

                $parameters["date1"]= $date1;
            }
            elseif(($date1 == "") && ($date2 != ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCalendar. " cal on e.id = cal.idEvent 
                INNER JOIN " .$this->tableNameArtistxCalendar. " axc on cal.idCalendar = axc.idCalendar 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id WHERE axc.idArtist= :idSearch
                AND cal.dateCalendar <= :date2;";

                $parameters["date2"]= $date1;
            }

            $resulSet= $this->connection->Execute($query, $parameters);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);

                
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetEventByCategoryId($categoryId, $date1= "", $date2= "")
    { //devuelve todos los event que estan asociados con algun category especifico
        //si le enviamos fecha , tambien filtra por fecha
        try
        {
            /* QUERY SIN FECHA
            SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription'  
            FROM events e INNER JOIN categories cat on e.categoryId= cat.id WHERE cat.id= 8
            */

            /* QUERY CON FECHA
            SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description', cal.dateCalendar as 'date' 
            FROM
            events e 
            INNER JOIN categories cat on e.categoryId= cat.id 
            INNER JOIN calendars cal on e.id= cal.idEvent
            WHERE cat.id= 1
            AND (cal.dateCalendar BETWEEN '2010-01-30' AND '2019-09-29');
            
            */
            $eventList= array();
            $parameters= array();
            $parameters["idSearch"]= $categoryId;

            if(($date1 == "") && ($date2 == ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description'  
                FROM " .$this->tableName. " e INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id WHERE cat.id= :idSearch";
                
            }
            elseif(($date1 != "") && ($date2 != ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description', cal.dateCalendar as 'date'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id 
                INNER JOIN ". $this->tableNameCalendar ." cal on e.id= cal.idEvent
                WHERE cat.id= :idSearch
                AND (cal.dateCalendar BETWEEN :date1 AND :date2);";

                $parameters["date1"]= $date1;
                $parameters["date2"]= $date2;
            }
            elseif(($date1 != "") && ($date2 == ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description', cal.dateCalendar as 'date'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id 
                INNER JOIN ". $this->tableNameCalendar ." cal on e.id= cal.idEvent
                WHERE cat.id= :idSearch
                AND cal.dateCalendar >= :date1;";

                $parameters["date1"]= $date1;
            }
            elseif(($date1 == "") && ($date2 != ""))
            {
                $query= " SELECT DISTINCT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', e.categoryId as 'categoryId', cat.name as 'categoryName', cat.description as 'description', cal.dateCalendar as 'date'  
                FROM " .$this->tableName. " e 
                INNER JOIN " .$this->tableNameCategory. " cat on e.categoryId= cat.id 
                INNER JOIN ". $this->tableNameCalendar ." cal on e.id= cal.idEvent
                WHERE cat.id= :idSearch
                AND cal.dateCalendar <= :date2;";

                $parameters["date2"]= $date1;
            }
            
            $resulSet= $this->connection->Execute($query, $parameters);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);

                
                array_push($eventList, $event);
            }
            return $eventList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetByeventId($id)
    {
        try
        {
            $event= null;
            $parameters= array();

            //SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description' FROM events e INNER JOIN categories c ON e.categoryId = c.id WHERE e.id= 9;
            $query= "SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description' FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id WHERE e.id= :id;";
            $parameters["id"]= $id;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);
            }
            return $event;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByeventName($eventName)
    {
        try
        {
            $event= null;
            $parameters= array();

            //SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description' FROM events e INNER JOIN categories c ON e.categoryId = c.id WHERE e.id= 9;
            $query= "SELECT e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', c.id as 'categoryId', c.name as 'categoryName', c.description as 'description' FROM ". $this->tableName . " e INNER JOIN " . $this->tableNameCategory . " c ON e.categoryId = c.id WHERE e.name= :eventName;";
            $parameters["eventName"]= $eventName;
            
            $resulSet= $this->connection->Execute($query, $parameters);
            
            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["description"]);
                
                $event = new event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
               
                $oPhoto= new Photo();
                $oPhoto->setPath($row["eventPicture"]);
                
                $event->setPhoto($oPhoto);
                $event->setcategory($category);
            }
            return $event;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function Deleteevent($id)
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

    public function Modifyevent($id, event $eventNew)
    {
        try
        {
            $parameters= array();
            $category= $eventNew->getcategory();
            $photo= $eventNew->getPhoto();
            
            $query= "UPDATE ". $this->tableName. " SET name= :name, categoryId= :categoryId, picture= :picture WHERE id= :idSearch;";
            
            $parameters["name"]= $eventNew->getName();
            $parameters["categoryId"]= $category->getId();
            $parameters["picture"]= $photo->getPath();
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