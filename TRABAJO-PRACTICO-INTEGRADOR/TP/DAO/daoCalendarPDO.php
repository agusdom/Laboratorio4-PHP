<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Model\Calendar as Calendar;
use Model\Event as Event;
use Model\Category as Category;
use Model\PlaceEvent as PlaceEvent;
use Model\Artist as Artist;
use Model\Photo as Photo;
use Dao\iDaoCalendar as iDaoCalendar;

class daoCalendarPDO implements iDaoCalendar
{
    private $connection;
    private $tableName= "Calendars";
    private $tableNameArtist= "artists";
    private $tableNameEvent= "events";
    private $tableNameCategory= "categories";
    private $tableNamePlaceEvent= "placeEvents";
    private $tableNameArtistsxCalendars= "artistsxcalendars";


    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddCalendar(Calendar $calendar)
    {
        try
        {
            $query= "INSERT INTO ". $this->tableName . " (dateCalendar, idEvent, idPlace) VALUES (:dateCalendar, :idEvent, :idPlace);";
            $parameters= array();
            $parameters["dateCalendar"]= $calendar->getDate();
            $oEvent= $calendar->getEvent();
            $oPlaceEvent= $calendar->getPlaceEvent();
            $parameters["idEvent"]= $oEvent->getId();
            $parameters["idPlace"]= $oPlaceEvent->getId();

            
            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);

            //SELECT idCalendar FROM calendars ORDER BY idCalendar DESC LIMIT 1;
            $query= "SELECT idCalendar FROM " . $this->tableName. " ORDER BY idCalendar DESC LIMIT 1;";
            $resulSet= $this->connection->Execute($query);
            foreach($resulSet as $row)
            {
                $calendar->setId($row["idCalendar"]);
            }
            
            $this->AddCalendarArtists($calendar, $calendar->getArtistList());
            return $rowCount;   
        }
        catch(Exception $ex)
        {
            throw $ex; 
        }
    }

    public function AddCalendarArtists(Calendar $calendar, $artistList)
    {
        try
        {
            //INSERT INTO artistsxcalendars (idArtist, idCalendar) VALUES (4, 8);
            $query= "INSERT INTO ". $this->tableNameArtistsxCalendars . " (idArtist, idCalendar) VALUES (:idArtist, :idCalendar);";
            $parameters= array();
            $rowCount= null;
           
            foreach($artistList as $artist)
            {
                $parameters["idCalendar"]= $calendar->getId();
                $parameters["idArtist"]= $artist->getId();
                $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
            }
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
            $calendarList= array();
            
            /*SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', cat.id as 'categoryId',
            cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName',
            p.capacity as 'placeEventCapacity' FROM calendars cal INNER JOIN events e ON cal.idEvent= e.id INNER JOIN categories cat ON e.categoryId = cat.id
            INNER JOIN placeevents p on cal.idPlace = p.id ORDER BY cal.idCalendar;*/
            
            $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id ORDER BY cal.idCalendar;";
            $resulSet= $this->connection->Execute($query);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["categoryDescription"]);

                $event= new Event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
                $oPhotoEvent= new Photo();
                $oPhotoEvent->setPath($row["eventPicture"]);
                $event->setPhoto($oPhotoEvent);

                $event->setCategory($category);
                
                $placeEvent= new PlaceEvent();
                $placeEvent->setId($row["placeEventId"]);
                $placeEvent->setName($row["placeEventName"]);
                $placeEvent->setCapacity($row["placeEventCapacity"]);
                
                $calendar = new Calendar();
                $calendar->setId($row["calendarId"]);
                $calendar->setDate($row["calendarDate"]);
                $calendar->setEvent($event);
                $calendar->setPlaceEvent($placeEvent);

                $query2= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                 WHERE axc.idCalendar = :idCal;";

                 $parameters["idCal"]= $calendar->getId();
                $resulSet1= $this->connection->Execute($query2, $parameters);
                $artistArray= array();
                foreach($resulSet1 as $row1)
                {
                    $artist= new Artist();
                    $artist->setId($row1["artistId"]);
                    $artist->setName($row1["artistName"]);
                    $artist->setLastName($row1["artistLastName"]);
                    $artist->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist= new Photo();
                    $oPhotoArtist->setPath($row1["artistPicture"]);
                    $artist->setPhoto($oPhotoArtist);

                    array_push($artistArray, $artist);
                }
                $calendar->setArtistList($artistArray);
                
                array_push($calendarList, $calendar);
            }
            return $calendarList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByCalendarId($id)
    {
        try
        {
            /*SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', cat.id as 'categoryId',
            cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName',
            p.capacity as 'placeEventCapacity' FROM calendars cal INNER JOIN events e ON cal.idEvent= e.id INNER JOIN categories cat ON e.categoryId = cat.id
            INNER JOIN placeevents p on cal.idPlace = p.id WHERE cal.idCalendar = :id;*/
            
            $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName' , e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE cal.idCalendar = :idSearch;";
            
            $parameters1=array();
            $parameters1["idSearch"]= $id;
           
            $resulSet= $this->connection->Execute($query, $parameters1);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["categoryDescription"]);

                $event= new Event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
                $oPhotoEvent= new Photo();
                $oPhotoEvent->setPath($row["eventPicture"]);
                $event->setPhoto($oPhotoEvent);

                $event->setCategory($category);
                
                $placeEvent= new PlaceEvent();
                $placeEvent->setId($row["placeEventId"]);
                $placeEvent->setName($row["placeEventName"]);
                $placeEvent->setCapacity($row["placeEventCapacity"]);
                
                $calendar = new Calendar();
                $calendar->setId($row["calendarId"]);
                $calendar->setDate($row["calendarDate"]);
                $calendar->setEvent($event);
                $calendar->setPlaceEvent($placeEvent);

                $query2= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture' 
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                 WHERE axc.idCalendar = :idCal;";

                 $parameters["idCal"]= $calendar->getId();
                $resulSet1= $this->connection->Execute($query2, $parameters);
                $artistArray= array();
                
                foreach($resulSet1 as $row1)
                {
                    $artist= new Artist();
                    $artist->setId($row1["artistId"]);
                    $artist->setName($row1["artistName"]);
                    $artist->setLastName($row1["artistLastName"]);
                    $artist->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist= new Photo();
                    $oPhotoArtist->setPath($row1["artistPicture"]);
                    $artist->setPhoto($oPhotoArtist);
                    array_push($artistArray, $artist);
                }
                $calendar->setArtistList($artistArray);
                
            }
            return $calendar;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByPlaceEventId($placeEventId)
    {
        try
        {
            /*SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', cat.id as 'categoryId',
            cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName',
            p.capacity as 'placeEventCapacity' FROM calendars cal INNER JOIN events e ON cal.idEvent= e.id INNER JOIN categories cat ON e.categoryId = cat.id
            INNER JOIN placeevents p on cal.idPlace = p.id WHERE cal.idCalendar = :id;*/
            
            $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName' , e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE cal.idPlace = :idSearch;";
            
            $parameters1=array();
            $parameters1["idSearch"]= $placeEventId;
           
            $resulSet= $this->connection->Execute($query, $parameters1);
            $calendar= null;
            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["categoryDescription"]);

                $event= new Event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
                $oPhotoEvent= new Photo();
                $oPhotoEvent->setPath($row["eventPicture"]);
                $event->setPhoto($oPhotoEvent);

                $event->setCategory($category);
                
                $placeEvent= new PlaceEvent();
                $placeEvent->setId($row["placeEventId"]);
                $placeEvent->setName($row["placeEventName"]);
                $placeEvent->setCapacity($row["placeEventCapacity"]);
                
                $calendar = new Calendar();
                $calendar->setId($row["calendarId"]);
                $calendar->setDate($row["calendarDate"]);
                $calendar->setEvent($event);
                $calendar->setPlaceEvent($placeEvent);

                $query2= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture' 
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                 WHERE axc.idCalendar = :idCal;";

                 $parameters["idCal"]= $calendar->getId();
                $resulSet1= $this->connection->Execute($query2, $parameters);
                $artistArray= array();
                
                foreach($resulSet1 as $row1)
                {
                    $artist= new Artist();
                    $artist->setId($row1["artistId"]);
                    $artist->setName($row1["artistName"]);
                    $artist->setLastName($row1["artistLastName"]);
                    $artist->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist= new Photo();
                    $oPhotoArtist->setPath($row1["artistPicture"]);
                    $artist->setPhoto($oPhotoArtist);
                    array_push($artistArray, $artist);
                }
                $calendar->setArtistList($artistArray); 
            }
            return $calendar;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetCalendarByBetweenDates($date1= "", $date2= "")
    {//devuelve todos los calendarios filtrados por fecha
        try
        {
            $calendarList= array();
            $parameters= array();
            /*
           SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM calendars cal INNER JOIN events e ON cal.idEvent = e.id INNER JOIN categories cat ON e.categoryId = cat.id
                INNER JOIN placeevents p on cal.idPlace = p.id 
                WHERE (cal.dateCalendar BETWEEN '2018-12-01' AND '2018-12-30');
            */
            if(($date1 != "") && ($date2 != ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id 
                WHERE (cal.dateCalendar BETWEEN :date1 AND :date2)
                ORDER BY cal.dateCalendar;";

                $parameters["date1"]= $date1;
                $parameters["date2"]= $date2;
            }
            elseif(($date1 != "") && ($date2 == ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id
                WHERE (cal.dateCalendar >= :date1)
                ORDER BY cal.dateCalendar;";

                $parameters["date1"]= $date1;
            }
            elseif(($date1 == "") && ($date2 != ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id
                WHERE (cal.dateCalendar <= :date2)
                ORDER BY cal.dateCalendar;";
                $parameters["date2"]= $date2;
            }
            
            $resulSet= $this->connection->Execute($query, $parameters);

            foreach($resulSet as $row)
            {
                $category= new category();
                $category->setId($row["categoryId"]);
                $category->setName($row["categoryName"]);
                $category->setDescription($row["categoryDescription"]);

                $event= new Event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
                $oPhotoEvent= new Photo();
                $oPhotoEvent->setPath($row["eventPicture"]);
                $event->setPhoto($oPhotoEvent);

                $event->setCategory($category);
                
                $placeEvent= new PlaceEvent();
                $placeEvent->setId($row["placeEventId"]);
                $placeEvent->setName($row["placeEventName"]);
                $placeEvent->setCapacity($row["placeEventCapacity"]);
                
                $calendar = new Calendar();
                $calendar->setId($row["calendarId"]);
                $calendar->setDate($row["calendarDate"]);
                $calendar->setEvent($event);
                $calendar->setPlaceEvent($placeEvent);

                $query2= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                 WHERE axc.idCalendar = :idCal;";

                $parameters1= array();
                $parameters1["idCal"]= $calendar->getId();
                $resulSet1= $this->connection->Execute($query2, $parameters1);
                $artistArray= array();
                foreach($resulSet1 as $row1)
                {
                    $artist= new Artist();
                    $artist->setId($row1["artistId"]);
                    $artist->setName($row1["artistName"]);
                    $artist->setLastName($row1["artistLastName"]);
                    $artist->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist= new Photo();
                    $oPhotoArtist->setPath($row1["artistPicture"]);
                    $artist->setPhoto($oPhotoArtist);

                    array_push($artistArray, $artist);
                }
                $calendar->setArtistList($artistArray);
                
                array_push($calendarList, $calendar);
            }
            //var_dump($calendarList);
            return $calendarList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetCalendarByCategoryId($categoryId, $date1= "", $date2= "")
    { //devuelve todos los calendarios que estan asociados con algun category especifico
        //si le enviamos fecha , tambien filtra por fecha
        try
        {
            
            $calendarList= array();
            $parameters= array();
            $parameters["idSearch"]= $categoryId;

            if(($date1 == "") && ($date2 == ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id
                WHERE cat.id= :idSearch
                ORDER BY cal.dateCalendar;";
            }
            elseif(($date1 != "") && ($date2 != ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id 
                WHERE cat.id= :idSearch
                AND (cal.dateCalendar BETWEEN :date1 AND :date2)
                ORDER BY cal.dateCalendar;";

                $parameters["date1"]= $date1;
                $parameters["date2"]= $date2;
            }
            elseif(($date1 != "") && ($date2 == ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id 
                WHERE cat.id= :idSearch
                AND cal.dateCalendar >= :date1
                ORDER BY cal.dateCalendar;";

                $parameters["date1"]= $date1;
            }
            elseif(($date1 == "") && ($date2 != ""))
            {
                $query= "SELECT cal.idCalendar as 'calendarId', cal.dateCalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM ". $this->tableName . " cal INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
                INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id 
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
                $category->setDescription($row["categoryDescription"]);

                $event= new Event();
                $event->setId($row["eventId"]);
                $event->setName($row["eventName"]);
                $oPhotoEvent= new Photo();
                $oPhotoEvent->setPath($row["eventPicture"]);
                $event->setPhoto($oPhotoEvent);

                $event->setCategory($category);
                
                $placeEvent= new PlaceEvent();
                $placeEvent->setId($row["placeEventId"]);
                $placeEvent->setName($row["placeEventName"]);
                $placeEvent->setCapacity($row["placeEventCapacity"]);
                
                $calendar = new Calendar();
                $calendar->setId($row["calendarId"]);
                $calendar->setDate($row["calendarDate"]);
                $calendar->setEvent($event);
                $calendar->setPlaceEvent($placeEvent);

                $query2= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                WHERE axc.idCalendar = :idCal;";

                $parameters1= array();
                $parameters1["idCal"]= $calendar->getId();
                $resulSet1= $this->connection->Execute($query2, $parameters1);
                $artistArray= array();
                foreach($resulSet1 as $row1)
                {
                    $artist= new Artist();
                    $artist->setId($row1["artistId"]);
                    $artist->setName($row1["artistName"]);
                    $artist->setLastName($row1["artistLastName"]);
                    $artist->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist= new Photo();
                    $oPhotoArtist->setPath($row1["artistPicture"]);
                    $artist->setPhoto($oPhotoArtist);

                    array_push($artistArray, $artist);
                }
                $calendar->setArtistList($artistArray);
                
                array_push($calendarList, $calendar);
            }
            return $calendarList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }



    public function DeleteCalendar($id)
    {
        try
        {
            $parameters= array();

            //DELETE FROM calendars WHERE idCalendar= 30;
            $query= "DELETE FROM ". $this->tableName. " WHERE idCalendar= :id;";
            $parameters["id"]= $id;

            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
            return $rowCount;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifyCalendar($id, Calendar $calendarNew)
    {
        try
        {
            //actualizo los datos en la tabla calendars
            $parameters= array();
            
            $query= "UPDATE ". $this->tableName. " SET dateCalendar= :dateCalendar, idEvent= :idEvent, idPlace= :idPlace WHERE idCalendar= :idSearch;";
            
            $parameters["dateCalendar"]= $calendarNew->getDate();
            $oEvent= $calendarNew->getEvent();
            $parameters["idEvent"]= $oEvent->getId();
            $oPlaceEvent= $calendarNew->getPlaceEvent(); 
            $parameters["idPlace"]= $oPlaceEvent->getId();
            $parameters["idSearch"]= $id;

            $resulSet=$this->connection->ExecuteNonQuery($query, $parameters);

            //elimino los registros con id del calendario a modificar en la tabla artistsxCalendars
            $query1= "DELETE FROM ". $this->tableNameArtistsxCalendars. " WHERE idCalendar= :id;";
            $parameters1= array();
            $parameters1["id"]= $id; 
            $rowCount= $this->connection->ExecuteNonQuery($query1, $parameters1);

            //cargo los nuevos registros en la tabla artistsxCalendars
            $this->AddCalendarArtists($calendarNew, $calendarNew->getArtistList());
           
            return $rowCount;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
}

?>