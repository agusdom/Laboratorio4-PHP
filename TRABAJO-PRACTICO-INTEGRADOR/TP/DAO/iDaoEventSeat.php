<?php
namespace Dao;

use Model\EventSeat as EventSeat;

interface IDaoEventSeat
{
    function AddEventSeat(EventSeat $eventSeat);
    function GetAll();
    function GetByEventSeatId($idEventSeat);
    function GetByCalendarId($calendarId);
    function GetByEventId($idEvent);
    function ModifyEventSeat($id, EventSeat $eventSeatNew);
    function ModifyRemain($eventSeatId, EventSeat $eventSeatNew);
    function DeleteEventSeat($eventSeatId);
}

?>