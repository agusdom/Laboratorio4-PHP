<?php
namespace Dao;

use Model\Calendar as Calendar;

interface IDaoCalendar
{
    function GetAll();
    function AddCalendar(calendar $calendar);
    function GetByCalendarId($calendarId);
    function GetByPlaceEventId($placeEventId);
    function GetCalendarByBetweenDates($date1, $date2);
    function GetCalendarByCategoryId($categoryId, $date1, $date2);
    function ModifyCalendar($id, calendar $calendarNew);
    function DeleteCalendar($calendarId);
}

?>