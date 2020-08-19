<?php
namespace Dao;

use \Exception as Exception;
use Model\Purchase as Purchase;
use Model\PurchaseRow as PurchaseRow;
use Model\EventSeat as EventSeat;
use Model\User as User; 
use Model\Rol as Rol;
use Model\Calendar as Calendar;
use Model\Event as Event;
use Model\Category as Category;
use Model\PlaceEvent as PlaceEvent;
use Model\SeatType as SeatType;
use Model\Artist as Artist;
use Model\Photo as Photo;

use Dao\Connection as Connection;
use Dao\iDaoPurchase as iDaoPurchase;

class daoPurchasePDO implements iDaoPurchase
{
    private $connection;
    private $tableNamePurchase= "purchases";
    private $tableNamePurchaseRow= "purchaseRows";
    private $tableNameEventSeat= "eventSeats";
    private $tableNameArtist= "artists";
    private $tableNameRol= "rol";
    private $tableNameUser= "users";
    private $tableNameEvent= "events";
    private $tableNameCategory= "categories";
    private $tableNameCalendar= "calendars";
    private $tableNamePlaceEvent= "placeEvents";
    private $tableNameSeatType= "seatTypes";
    private $tableNameArtistsxCalendars= "artistsxcalendars";


    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function AddPurchase(Purchase $purchase)
    {
        try
        {
            /*
            echo "<pre>";
            var_dump($purchase);
            echo "</pre>";
            echo "<pre>";
            var_dump($purchaseRow);
            echo "</pre>";
            */
            
            //INSERT INTO purchases (datePurchase, idUser) VALUES ("2018-05-03", 2);
            $query= "INSERT INTO ". $this->tableNamePurchase . " (datePurchase, idUser) VALUES (:datePurchase, :idUser);";
            $parameters= array();
            $parameters["datePurchase"]= date("Y-m-d");
            $user= new User();
            $user= $purchase->getUser();
            
            $parameters["idUser"]= $user->getId();
            
            $rowCount= $this->connection->ExecuteNonQuery($query, $parameters);

            $query1= "SELECT idPurchase FROM " . $this->tableNamePurchase. " ORDER BY idPurchase DESC LIMIT 1;";
            $resulSet= $this->connection->Execute($query1);
            
            foreach($resulSet as $row)
            {
                $purchase->setId($row["idPurchase"]);
            }
            
            $purchaseRowArray= $purchase->getPurchaseRowList();
            
            $purchaseRowIdArray= array(); //va a contener los id de las filas de purchaseRow con las entradas que se estan por cargar
            
            foreach($purchaseRowArray as $purchaseRow)
            {
                $parameters2= array();

                $eventSeat= new EventSeat();
                $eventSeat= $purchaseRow->getEventSeat();
                
                $parameters2["idPurchase"]= $purchase->getId();
                $parameters2["idEventSeat"]= $eventSeat->getId();
                $quantity= $purchaseRow->getQuantity();
                $parameters2["quantity"]= "1";
                $parameters2["price"]= $purchaseRow->getPrice();

                for ($i=0; $i < $quantity ; $i++)
                { 
                    $query2= "INSERT INTO ". $this->tableNamePurchaseRow . " (idPurchase, idEventSeat, quantity, price) VALUES (:idPurchase, :idEventSeat, :quantity, :price);";
                    $rowCount= $this->connection->ExecuteNonQuery($query2, $parameters2);
                    
                    //esta query es para que me devuelva el id de la filas recien agregadas en la tabla purchaseRow
                    $query3= "SELECT idPurchaseRow FROM ". $this->tableNamePurchaseRow ." ORDER BY idPurchaseRow DESC LIMIT 1;";
                    
                    $resulset1= $this->connection->Execute($query3);
                    
                    foreach($resulset1 as $row1)
                    {
                        $purchaseRowId= $row1["idPurchaseRow"];
                        array_push($purchaseRowIdArray, $purchaseRowId);
                    }
                }
            }
            return $purchaseRowIdArray;

            /*foreach($purchaseRowArray as $purchaseRow)
            {
                $query2= "INSERT INTO ". $this->tableNamePurchaseRow . " (idPurchase, idEventSeat, quantity, price) VALUES (:idPurchase, :idEventSeat, :quantity, :price);";
                $parameters2= array();
                $parameters2["idPurchase"]= $purchase->getId();
                
                $eventSeat= new EventSeat();
                $eventSeat= $purchaseRow->getEventSeat();
                $parameters2["idEventSeat"]= $eventSeat->getId();
                $parameters2["quantity"]= $purchaseRow->getQuantity();
                $parameters2["price"]= $purchaseRow->getPrice();
    
                $rowCount= $this->connection->ExecuteNonQuery($query2, $parameters2);
            }*/
            
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
            $purchaseList= array();
           

             /*PURCHASE
                $id;
                 $date;
                 $user;
                 $purchaseRowList= array();*/

            $query1= "SELECT pu.idPurchase as 'purchaseId', pu.datePurchase as 'purchaseDate',
             pu.idUser as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword',
             u.rolId as 'rolId', r.name as 'rolName' 
            FROM " .$this->tableNamePurchase. " pu
            INNER JOIN " .$this->tableNameUser. " u ON pu.idUser = u.id
            INNER JOIN " .$this->tableNameRol." r ON u.rolId = r.id ORDER BY  pu.idPurchase;";
            
            $resulSet1= $this->connection->Execute($query1);

            foreach($resulSet1 as $row)
            {
                $purchaseRowArray= array();

                $rol= new Rol();
                $rol->setId($row["rolId"]);
                $rol->setName($row["rolName"]);

                $user= new User();
                $user->setId($row["userId"]);
                $user->setName($row["userName"]);
                $user->setLastName($row["userLastName"]);
                $user->setEmail($row["userEmail"]);
                $user->setPassword($row["userPassword"]);
                $user->setRol($rol);

                $purchase= new Purchase();
                $purchase->setId($row["purchaseId"]);
                $purchase->setDate($row["purchaseDate"]);
                $purchase->setUser($user);

                /*
                 PURCHASE ROW
                 private $id;
                private $price;
                private $quantity;
                private $eventSeat;
                 */
                /*
                SELECT pu.idPurchase as 'purchaseId', pu.datePurchase as 'purchaseDate', pu.idUser as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'rolId', r.name as 'rolName', pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice', es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM seatTypes st INNER JOIN eventSeats es ON st.idSeatType = es.idSeatType INNER JOIN calendars cal ON es.idCalendar= cal.idCalendar INNER JOIN events e ON cal.idEvent = e.id INNER JOIN categories cat ON e.categoryId = cat.id INNER JOIN placeEvents p on cal.idPlace = p.id INNER JOIN purchaseRows pr ON pr.idEventSeat = es.idEventSeat INNER JOIN purchases pu ON pr.idPurchase = pu.idPurchase INNER JOIN users u ON pu.idUser = u.id INNER JOIN rol r ON u.rolId = r.id ORDER BY pu.idPurchase; 
                */
                $query2= "SELECT pu.idPurchase as 'purchaseId',  
                pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
                es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
                st.typeName as 'typeName', es.idCalendar as 'calendarId', 
                cal.datecalendar as 'calendarDate', e.id as 'eventId', 
                e.name as 'eventName', e.picture as 'eventPicture', 
                cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
                p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM " . $this->tableNameSeatType. " st 
                INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
                INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
                INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
                INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
                INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
                INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
                INNER JOIN ". $this->tableNamePurchase ." pu ON pr.idPurchase = pu.idPurchase 
                WHERE pu.idPurchase= :idSearch; ";
                
                $parameters2= array();
                $parameters2["idSearch"]= $purchase->getId();
                $resulSet2= $this->connection->Execute($query2, $parameters2);

                foreach($resulSet2 as $row)
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

                    $query3= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                    FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                    WHERE axc.idCalendar = :idCal;";

                    $parameters3["idCal"]= $calendar->getId();
                    $resulSet3= $this->connection->Execute($query3, $parameters3);
                    $artistArray= array();
                    
                    foreach($resulSet3 as $row1)
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

                    
                    $purchaseRow= new PurchaseRow();
                    $purchaseRow->setId($row["purchaseRowId"]);
                    $purchaseRow->setPrice($row["purchaseRowPrice"]);
                    $purchaseRow->setQuantity($row["purchaseRowQuantity"]);
                    $purchaseRow->setEventSeat($eventSeat);

                    array_push($purchaseRowArray, $purchaseRow);
                    
                }

                $purchase->setPurchaseRowList($purchaseRowArray);

                array_push($purchaseList, $purchase);
               
                
                /*PURCHASE
                $id;
                 $date;
                 $user;
                 $purchaseRowList= array();*/

                 /*
                 PURCHASE ROW
                 private $id;
                private $price;
                private $quantity;
                private $eventSeat;
                 */

                
            }
            return $purchaseList;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function GetPurchaseSumQuantityByCalendar($calendarId)
    {//devuelve un arreglo de purchaseRow que se corresponda con un id de calendario asociado
    //los resultados estan agrupados por tipo de asiento y sumadas las cantidades vendidas

        try
        {
            // inicio purchase row
            
            $purchaseRowArray= array();
            
            // SELECT pu.idPurchase as 'purchaseId',  
            // pr.idPurchaseRow as 'purchaseRowId', sum(pr.quantity) as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
            // es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            // st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            // cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            // e.name as 'eventName', e.picture as 'eventPicture', 
            // cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            // p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            // FROM seattypes st 
            // INNER JOIN eventseats es ON st.idSeatType = es.idSeatType 
            // INNER JOIN calendars cal ON es.idCalendar= cal.idCalendar 
            // INNER JOIN events e ON cal.idEvent = e.id 
            // INNER JOIN categories cat ON e.categoryId = cat.id 
            // INNER JOIN placeevents p on cal.idPlace = p.id 
            // INNER JOIN purchaserows pr ON pr.idEventSeat = es.idEventSeat 
            // INNER JOIN purchases pu ON pr.idPurchase = pu.idPurchase 
            // WHERE cal.idCalendar= 1
            // GROUP BY st.idSeatType;

            $query3= "SELECT pu.idPurchase as 'purchaseId',  
            pr.idPurchaseRow as 'purchaseRowId', sum(pr.quantity) as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
            es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            e.name as 'eventName', e.picture as 'eventPicture', 
            cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM " . $this->tableNameSeatType. " st 
            INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
            INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
            INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
            INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
            INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
            INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
            INNER JOIN ". $this->tableNamePurchase ." pu ON pr.idPurchase = pu.idPurchase 
            WHERE cal.idCalendar= :idCalendar
            GROUP BY st.idSeatType;";
            
            $parameters2= array();
            $parameters2["idCalendar"]= $calendarId;
            $resulSet2= $this->connection->Execute($query3, $parameters2);

            
            foreach($resulSet2 as $row)
            {
                $category1= new category();
                $category1->setId($row["categoryId"]);
                $category1->setName($row["categoryName"]);
                $category1->setDescription($row["categoryDescription"]);

                $event1= new Event();
                $event1->setId($row["eventId"]);
                $event1->setName($row["eventName"]);
            
                $oPhotoEvent1= new Photo();
                $oPhotoEvent1->setPath($row["eventPicture"]);
                
                $event1->setPhoto($oPhotoEvent1);
                $event1->setCategory($category1);
                
                $placeEvent1= new PlaceEvent();
                $placeEvent1->setId($row["placeEventId"]);
                $placeEvent1->setName($row["placeEventName"]);
                $placeEvent1->setCapacity($row["placeEventCapacity"]);
                
                $calendar1 = new calendar();
                $calendar1->setId($row["calendarId"]);
                $calendar1->setDate($row["calendarDate"]);
                $calendar1->setEvent($event1);
                $calendar1->setPlaceEvent($placeEvent1);

                $query4= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                WHERE axc.idCalendar = :idCal;";

                $parameters3["idCal"]= $calendar1->getId();
                $resulSet3= $this->connection->Execute($query4, $parameters3);
                $artistArray1= array();
                
                foreach($resulSet3 as $row1)
                {
                    $artist1= new Artist();
                    $artist1->setId($row1["artistId"]);
                    $artist1->setName($row1["artistName"]);
                    $artist1->setLastName($row1["artistLastName"]);
                    $artist1->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist1= new Photo();
                    $oPhotoArtist1->setPath($row1["artistPicture"]);
                    $artist1->setPhoto($oPhotoArtist1);

                    array_push($artistArray1, $artist1);
                }
                $calendar1->setArtistList($artistArray1);
            
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
            
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar1);
                $eventSeat->setSeatType($SeatType);

                
                $purchaseRow= new PurchaseRow();
                $purchaseRow->setId($row["purchaseRowId"]);
                $purchaseRow->setPrice($row["purchaseRowPrice"]);
                $purchaseRow->setQuantity($row["purchaseRowQuantity"]);
                $purchaseRow->setEventSeat($eventSeat);

                array_push($purchaseRowArray, $purchaseRow);
                
            }
            
            return $purchaseRowArray;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetPurchasRowByCalendar($calendarId)
    {//devuelve un arreglo de purchaseRow que se corresponda con un id de calendario asociado
        try
        {
            // inicio purchase row
            
            $purchaseRowArray= array();
            
            // SELECT   
            // pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
            // es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            // st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            // cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            // e.name as 'eventName', e.picture as 'eventPicture', 
            // cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            // p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            // FROM seattypes st 
            // INNER JOIN eventseats es ON st.idSeatType = es.idSeatType 
            // INNER JOIN calendars cal ON es.idCalendar= cal.idCalendar 
            // INNER JOIN events e ON cal.idEvent = e.id 
            // INNER JOIN categories cat ON e.categoryId = cat.id 
            // INNER JOIN placeevents p on cal.idPlace = p.id 
            // INNER JOIN purchaserows pr ON pr.idEventSeat = es.idEventSeat 
            // INNER JOIN purchases pu ON pr.idPurchase = pu.idPurchase 
            // WHERE cal.idCalendar= 1

            $query3= "SELECT pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
            es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            e.name as 'eventName', e.picture as 'eventPicture', 
            cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM " . $this->tableNameSeatType. " st 
            INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
            INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
            INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
            INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
            INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
            INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
            WHERE cal.idCalendar= :idCalendar";
            
            $parameters2= array();
            $parameters2["idCalendar"]= $calendarId;
            $resulSet2= $this->connection->Execute($query3, $parameters2);

            
            foreach($resulSet2 as $row)
            {
                $category1= new category();
                $category1->setId($row["categoryId"]);
                $category1->setName($row["categoryName"]);
                $category1->setDescription($row["categoryDescription"]);

                $event1= new Event();
                $event1->setId($row["eventId"]);
                $event1->setName($row["eventName"]);
            
                $oPhotoEvent1= new Photo();
                $oPhotoEvent1->setPath($row["eventPicture"]);
                
                $event1->setPhoto($oPhotoEvent1);
                $event1->setCategory($category1);
                
                $placeEvent1= new PlaceEvent();
                $placeEvent1->setId($row["placeEventId"]);
                $placeEvent1->setName($row["placeEventName"]);
                $placeEvent1->setCapacity($row["placeEventCapacity"]);
                
                $calendar1 = new calendar();
                $calendar1->setId($row["calendarId"]);
                $calendar1->setDate($row["calendarDate"]);
                $calendar1->setEvent($event1);
                $calendar1->setPlaceEvent($placeEvent1);

                $query4= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                WHERE axc.idCalendar = :idCal;";

                $parameters3["idCal"]= $calendar1->getId();
                $resulSet3= $this->connection->Execute($query4, $parameters3);
                $artistArray1= array();
                
                foreach($resulSet3 as $row1)
                {
                    $artist1= new Artist();
                    $artist1->setId($row1["artistId"]);
                    $artist1->setName($row1["artistName"]);
                    $artist1->setLastName($row1["artistLastName"]);
                    $artist1->setArtisticName($row1["artisticName"]);
                    $oPhotoArtist1= new Photo();
                    $oPhotoArtist1->setPath($row1["artistPicture"]);
                    $artist1->setPhoto($oPhotoArtist1);

                    array_push($artistArray1, $artist1);
                }
                $calendar1->setArtistList($artistArray1);
            
                $SeatType= new SeatType();
                $SeatType->setId($row["idSeatType"]);
                $SeatType->setType($row["typeName"]);
            
                $eventSeat= new EventSeat();
                $eventSeat->setId($row["eventSeatId"]);
                $eventSeat->setPrice($row["price"]);
                $eventSeat->setQuantity($row["quantity"]);
                $eventSeat->setRemains($row["remains"]);
                $eventSeat->setCalendar($calendar1);
                $eventSeat->setSeatType($SeatType);

                
                $purchaseRow= new PurchaseRow();
                $purchaseRow->setId($row["purchaseRowId"]);
                $purchaseRow->setPrice($row["purchaseRowPrice"]);
                $purchaseRow->setQuantity($row["purchaseRowQuantity"]);
                $purchaseRow->setEventSeat($eventSeat);

                array_push($purchaseRowArray, $purchaseRow);
                
            }
            
            return $purchaseRowArray;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    /*
    public function GetPurchaseSumQuantityByCalendar()
    {//la idea es que devuelva un arreglo bidimensional que por cada fila tenga un calendario y por cada columna todos los 
        //purchaseRow que se correspondan con ese calendario  

        try
        {
            $calendarList= array();
            
            
            
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
            
            // inicio purchase row
            
            $purchaseRowArray= array();
            foreach($calendarList as $calendar2)
            {

                $query3= "SELECT pu.idPurchase as 'purchaseId',  
                pr.idPurchaseRow as 'purchaseRowId', sum(pr.quantity) as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
                es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
                st.typeName as 'typeName', es.idCalendar as 'calendarId', 
                cal.datecalendar as 'calendarDate', e.id as 'eventId', 
                e.name as 'eventName', e.picture as 'eventPicture', 
                cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
                p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
                FROM " . $this->tableNameSeatType. " st 
                INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
                INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
                INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
                INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
                INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
                INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
                INNER JOIN ". $this->tableNamePurchase ." pu ON pr.idPurchase = pu.idPurchase 
                WHERE cal.idCalendar= :idCalendar
                GROUP BY st.idSeatType;";
                
                $parameters2= array();
                $parameters2["idCalendar"]= $calendar2->getId();
                $resulSet2= $this->connection->Execute($query3, $parameters2);

                
                foreach($resulSet2 as $row)
                {
                    $category1= new category();
                    $category1->setId($row["categoryId"]);
                    $category1->setName($row["categoryName"]);
                    $category1->setDescription($row["categoryDescription"]);

                    $even1t= new Event();
                    $event1->setId($row["eventId"]);
                    $event1->setName($row["eventName"]);
                
                    $oPhotoEvent1= new Photo();
                    $oPhotoEvent1->setPath($row["eventPicture"]);
                    
                    $event1->setPhoto($oPhotoEvent1);
                    $event1->setCategory($category1);
                    
                    $placeEvent1= new PlaceEvent();
                    $placeEvent1->setId($row["placeEventId"]);
                    $placeEvent1->setName($row["placeEventName"]);
                    $placeEvent1->setCapacity($row["placeEventCapacity"]);
                    
                    $calendar1 = new calendar();
                    $calendar1->setId($row["calendarId"]);
                    $calendar1->setDate($row["calendarDate"]);
                    $calendar1->setEvent($event1);
                    $calendar1->setPlaceEvent($placeEvent1);

                    $query4= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                    FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                    WHERE axc.idCalendar = :idCal;";

                    $parameters3["idCal"]= $calendar->getId();
                    $resulSet3= $this->connection->Execute($query3, $parameters3);
                    $artistArray1= array();
                    
                    foreach($resulSet3 as $row1)
                    {
                        $artist1= new Artist();
                        $artist1->setId($row1["artistId"]);
                        $artist1->setName($row1["artistName"]);
                        $artist1->setLastName($row1["artistLastName"]);
                        $artist1->setArtisticName($row1["artisticName"]);
                        $oPhotoArtist1= new Photo();
                        $oPhotoArtist1->setPath($row1["artistPicture"]);
                        $artist1->setPhoto($oPhotoArtist1);

                        array_push($artistArray1, $artist1);
                    }
                    $calendar1->setArtistList($artistArray1);
                
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

                    
                    $purchaseRow= new PurchaseRow();
                    $purchaseRow->setId($row["purchaseRowId"]);
                    $purchaseRow->setPrice($row["purchaseRowPrice"]);
                    $purchaseRow->setQuantity($row["purchaseRowQuantity"]);
                    $purchaseRow->setEventSeat($eventSeat);

                    array_push($purchaseRowArray, $purchaseRow);
                    
                }
                
            }
            
            
            return $purchaseRowArray;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
    */


    public function GetTotalByCalendar($calendarId)
    {//devuelve un importe total de entradas vendidas que se corresponda con un id de calendario asociado
        try
        {
            $query3= "SELECT pr.idPurchaseRow as 'purchaseRowId', sum(pr.quantity * pr.price) as 'total',
            es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            e.name as 'eventName', e.picture as 'eventPicture', 
            cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM " . $this->tableNameSeatType. " st 
            INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
            INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
            INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
            INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
            INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
            INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
            WHERE cal.idCalendar= :idCalendar";
            
            $parameters2= array();
            $parameters2["idCalendar"]= $calendarId;
            $resulSet2= $this->connection->Execute($query3, $parameters2);
            $total= null;
            
            foreach($resulSet2 as $row)
            {
                $total= $row["total"];
            }
            
            return $total;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }



    public function GetPurchaseRowById($purchaseRowId)
    {
        try
        {  
            /*
            SELECT pu.idPurchase as 'purchaseId', pu.datePurchase as 'purchaseDate', pu.idUser as 'userId', u.name as 'userName', u.lastName as 'userLastName', u.email as 'userEmail', u.password as 'userPassword', u.rolId as 'rolId', r.name as 'rolName', pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice', es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', st.typeName as 'typeName', es.idCalendar as 'calendarId', cal.datecalendar as 'calendarDate', e.id as 'eventId', e.name as 'eventName', e.picture as 'eventPicture', cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription', p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM seatTypes st INNER JOIN eventSeats es ON st.idSeatType = es.idSeatType INNER JOIN calendars cal ON es.idCalendar= cal.idCalendar INNER JOIN events e ON cal.idEvent = e.id INNER JOIN categories cat ON e.categoryId = cat.id INNER JOIN placeEvents p on cal.idPlace = p.id INNER JOIN purchaseRows pr ON pr.idEventSeat = es.idEventSeat INNER JOIN purchases pu ON pr.idPurchase = pu.idPurchase INNER JOIN users u ON pu.idUser = u.id INNER JOIN rol r ON u.rolId = r.id ORDER BY pu.idPurchase; 
            */
            $query2= "SELECT   
            pr.idPurchaseRow as 'purchaseRowId', pr.quantity as 'purchaseRowQuantity', pr.price as 'purchaseRowPrice',
            es.idEventSeat as 'eventSeatId', es.price as 'price', es.quantity as 'quantity', es.remains as 'remains', es.idSeatType as 'idSeatType', 
            st.typeName as 'typeName', es.idCalendar as 'calendarId', 
            cal.datecalendar as 'calendarDate', e.id as 'eventId', 
            e.name as 'eventName', e.picture as 'eventPicture', 
            cat.id as 'categoryId', cat.name as 'categoryName', cat.description as 'categoryDescription',
            p.id as 'placeEventId', p.name as 'placeEventName', p.capacity as 'placeEventCapacity' 
            FROM " . $this->tableNameSeatType. " st 
            INNER JOIN " .$this->tableNameEventSeat." es ON st.idSeatType = es.idSeatType 
            INNER JOIN " .$this->tableNameCalendar. " cal ON es.idCalendar= cal.idCalendar 
            INNER JOIN ". $this->tableNameEvent ." e ON cal.idEvent = e.id 
            INNER JOIN " .$this->tableNameCategory. " cat ON e.categoryId = cat.id 
            INNER JOIN " .$this->tableNamePlaceEvent. " p on cal.idPlace = p.id 
            INNER JOIN " .$this->tableNamePurchaseRow. " pr ON pr.idEventSeat = es.idEventSeat 
            WHERE pr.idPurchaseRow= :idSearch; ";
            
            $parameters2= array();
            $parameters2["idSearch"]= $purchaseRowId;
            $resulSet2= $this->connection->Execute($query2, $parameters2);

            foreach($resulSet2 as $row)
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

                $query3= "SELECT axc.idCalendar as 'calendarId', a.id as 'artistId', a.name as 'artistName', a.lastName as 'artistLastName', a.artisticName as 'artisticName', a.picture as 'artistPicture'
                FROM ". $this->tableNameArtistsxCalendars. " axc INNER JOIN " . $this->tableNameArtist . " a ON axc.idArtist = a.id
                WHERE axc.idCalendar = :idCal;";

                $parameters3["idCal"]= $calendar->getId();
                $resulSet3= $this->connection->Execute($query3, $parameters3);
                $artistArray= array();
                
                foreach($resulSet3 as $row1)
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

                
                $purchaseRow= new PurchaseRow();
                $purchaseRow->setId($row["purchaseRowId"]);
                $purchaseRow->setPrice($row["purchaseRowPrice"]);
                $purchaseRow->setQuantity($row["purchaseRowQuantity"]);
                $purchaseRow->setEventSeat($eventSeat);
                
            }

            return $purchaseRow;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


   
}

?>