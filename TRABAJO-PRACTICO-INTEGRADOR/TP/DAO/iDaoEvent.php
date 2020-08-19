<?php
namespace Dao;

use Model\Event as Event;

interface IDaoEvent
{
    function GetAll();
    function GetAllByDate();
    function AddEvent(Event $event);
    function GetByEventId($eventId);
    function GetByBetweenDates($date1, $date2);
    function GetEventByArtistId($artistId, $date1= "", $date2= "");
    function GetByeventName($eventName);
    function GetEventByCategoryId($categoryId, $date1= "", $date2= "");
    function ModifyEvent($id, Event $eventNew);
    function DeleteEvent($eventId);
}

?>