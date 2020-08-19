<?php
namespace Dao;

use \Exception as Exception;
use Dao\Connection as Connection;
use Dao\IDaoEventSeat as IDaoEventSeat;
use Model\Calendar as Calendar;
use Model\SeatType as SeatType;
use Model\Event as Event;
use Model\Category as Category;
use Model\PlaceEvent as PlaceEvent;
use Model\EventSeat as EventSeat;
use Model\Artist as Artist;
use Model\Photo as Photo;


class daoEventSeatPDO implements IDaoEventSeat
{
    private $connection;
    private $tableName= "EventSeats";
    private $tableNameCalendar= "calendars";
    private $tableNameSeatType= "SeatTypes";
    private $tableNameArtist= "artists";
    private $tableNameEvent= "events";
    private $tableNameCategory= "categories";
    private $tableNamePlaceEvent= "placeEvents";
    private $tableNameArtistsxCalendars= "artistsxCalendars";


    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddEventSeat(EventSeat $eventSeat)
    {
        try
        {
            //INSERT INTO eventseats (price, quantity, remains, idCalendar, idSeatType) VALUES (12, 100, 100, 32, 1);
            $query= "INSERT INTO ". $this->tableName . " (price, quantity, remains, idCalendar, idSeatType) VALUES (:price, :quantity, :remains, :idCalendar, :idSeatType);";
            $parameters= array();
            $parameters["price"]= $eventSeat->getPrice();
            $parameters["quantity"]= $eventSeat->getQuantity();
            $parameters["remains"]= $eventSeat->getRemains();
            $calendar= new Calendar();
            $seatType= new SeatType();
            $calendar= $eventSeat->getCalendar();
            $seatType= $eventSeat->getSeatType();
            $parameters["idCalendar"]= $calendar->getId();
            $parameters["idSeatType"]= $seatType->getId();
            
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
            $calendarList= array();
            
            /*SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM seattypes st INNER JOIN eventseats es ON st.idSeatType = es.idSeatType INNER JOIN calendars cal ON es.idCalendar= cal.idCalendar INNER JOIN events e ON cal.idEvent = e.id
            INNER JOIN categories cat ON e.categoryId = cat.id
            INNER JOIN placeevents p on cal.idPlace = p.id ORDER BY es.idcalendar;*/
            
            $query= "SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableNameSeatType . " st INNER JOIN " . $this->tableName . " es ON st.idSeatType = es.idSeatType INNER JOIN " . $this->tableNameCalendar . " cal ON es.idCalendar= cal.idCalendar INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id ORDER BY es.idcalendar;";
            
            $resulSet= $this->connection->Execute($query);
            $eventSeatList= array();

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
                
                $calendar = new calendar();
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
               
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
               
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar);
                $eventSeat->setSeatType($SeatType);

                array_push($eventSeatList, $eventSeat);
            }
            return $eventSeatList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByCalendarId($id)
    {//devuelve todos los registros event seat que estan relacionados con un id de calendario
        try
        {
            
            $query= "SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableNameSeatType . " st INNER JOIN " . $this->tableName . " es ON st.idSeatType = es.idSeatType INNER JOIN " . $this->tableNameCalendar . " cal ON es.idCalendar= cal.idCalendar INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE es.idcalendar= :idSearch;";
            
            $parameters1= array();
            $parameters1["idSearch"]= $id;
           
            $resulSet= $this->connection->Execute($query, $parameters1);
            $eventSeatList= array();

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
               
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
               
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar);
                $eventSeat->setSeatType($SeatType);

                array_push($eventSeatList, $eventSeat);
            }
            return $eventSeatList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByEventSeatId($idEventSeat)
    {
        try
        {
            
            $query= "SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableNameSeatType . " st INNER JOIN " . $this->tableName . " es ON st.idSeatType = es.idSeatType INNER JOIN " . $this->tableNameCalendar . " cal ON es.idCalendar= cal.idCalendar INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE es.idEventSeat= :idSearch;";
            
            $parameters1= array();
            $parameters1["idSearch"]= $idEventSeat;
           
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
               
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
               
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar);
                $eventSeat->setSeatType($SeatType);

            }
            return $eventSeat;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetByEventId($idEvent)
    {//devuelve todos los eventSeat que se corresponden con un id de event
        try
        {
            
            $query= "SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableNameSeatType . " st INNER JOIN " . $this->tableName . " es ON st.idSeatType = es.idSeatType INNER JOIN " . $this->tableNameCalendar . " cal ON es.idCalendar= cal.idCalendar INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE e.id= :idSearch;";
            
            $parameters1= array();
            $parameters1["idSearch"]= $idEvent;
           
            $resulSet= $this->connection->Execute($query, $parameters1);
        
            $eventSeatList= array();

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
                
                $calendar = new calendar();
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
               
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
               
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar);
                $eventSeat->setSeatType($SeatType);

                array_push($eventSeatList, $eventSeat);
            }
            return $eventSeatList;
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetBySeatTypeId($idSeatType)
    {//devuelve todos los eventSeat que se corresponden con un id de event
        try
        {
            
            $query= "SELECT es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM ". $this->tableNameSeatType . " st INNER JOIN " . $this->tableName . " es ON st.idSeatType = es.idSeatType INNER JOIN " . $this->tableNameCalendar . " cal ON es.idCalendar= cal.idCalendar INNER JOIN " . $this->tableNameEvent . " e ON cal.idEvent = e.id INNER JOIN ". $this->tableNameCategory ." cat ON e.categoryId = cat.id
            INNER JOIN " . $this->tableNamePlaceEvent . " p on cal.idPlace = p.id WHERE st.idSeatType= :idSearch;";
            
            $parameters1= array();
            $parameters1["idSearch"]= $idSeatType;
           
            $resulSet= $this->connection->Execute($query, $parameters1);
        
            $eventSeatList= array();

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
                
                $calendar = new calendar();
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
               
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
               
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar);
                $eventSeat->setSeatType($SeatType);

                array_push($eventSeatList, $eventSeat);
            }
            return $eventSeatList;
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function DeleteEventSeat($idEventSeat)
    {
        try
        {
            $parameters= array();


            $query= "DELETE FROM ". $this->tableName. " WHERE idEventSeat= :id;";
            $parameters["id"]= $idEventSeat;

            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);
            return $rowCount;

        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifyEventSeat($id, EventSeat $eventSeatNew)
    {
        try
        {
            //actualizo los datos en la tabla EventSeat
            $parameters= array();
            
            $query= "UPDATE ". $this->tableName. " SET idEventSeat= :idEventSeat, price= :price, quantity= :quantity, remains= :remains, idCalendar= :idCalendar, idSeatType= :idSeatType WHERE idEventSeat= :idSearch;";
            
            $parameters["idEventSeat"]= $eventSeatNew->getId();
            $parameters["price"]= $eventSeatNew->getPrice();
            $parameters["quantity"]= $eventSeatNew->getQuantity();
            $parameters["remains"]= $eventSeatNew->getRemains();
            $calendar= $eventSeatNew->getCalendar();
            $seatType= $eventSeatNew->getSeatType();
            $parameters["idCalendar"]= $calendar->getId();
            $parameters["idSeatType"]= $seatType->getId();

            $parameters["idSearch"]= $id;

            $rowCount=$this->connection->ExecuteNonQuery($query, $parameters);
           
            return $rowCount;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function ModifyRemain($eventSeatId, EventSeat $eventSeatNew)
    {
        //actualizo los datos en la tabla EventSeat
        $parameters= array();
            
        $query= "UPDATE ". $this->tableName. " SET idEventSeat= :idEventSeat, price= :price, quantity= :quantity, remains= :remains, idCalendar= :idCalendar, idSeatType= :idSeatType WHERE idEventSeat= :idSearch;";
        
        $parameters["idEventSeat"]= $eventSeatNew->getId();
        $parameters["price"]= $eventSeatNew->getPrice();
        $parameters["quantity"]= $eventSeatNew->getQuantity();
        $parameters["remains"]= $eventSeatNew->getRemains();
        $calendar= $eventSeatNew->getCalendar();
        $seatType= $eventSeatNew->getSeatType();
        $parameters["idCalendar"]= $calendar->getId();
        $parameters["idSeatType"]= $seatType->getId();

        $parameters["idSearch"]= $eventSeatId;

        $rowCount=$this->connection->ExecuteNonQuery($query, $parameters);
       
        return $rowCount;
    }
}

?>