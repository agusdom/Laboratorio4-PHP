<?php
namespace Dao;

use Dao\IDaoCalendar as IDaoCalendar;
use Model\Calendar as Calendar;

class DaoCalendarList implements IDaoCalendar
{
    private $calendarList;

    public function __construct()
    {
       if(!isset($_SESSION["calendarList"]))
       {
            $_SESSION["calendarList"]= array(); 
       }
       $this->calendarList= &$_SESSION["calendarList"];
    }


    public function GetAll()
    {
        return $this->calendarList;
    }


    public function AddCalendar(Calendar $calendar)
    {
        $id=0;
        if(!isset($_SESSION["CalendarId"]))
        {
            $id=1;
            $_SESSION["CalendarId"]= $id;
        }
        else
        {
            $id= $_SESSION["CalendarId"];
            $id++;
            $_SESSION["CalendarId"]= $id;
        }
        $calendar->setId($id);
        array_push($this->calendarList, $calendar);
    }

    public function GetByCalendarId($calendarId)
    {
    //busca un objeto en el repositorio por el id 
    //devuelve el objeto si lo encuentra, sino devuelve null
        $object= null;

        foreach($this->calendarList as $calendar)
        {
            if($calendar->getId() == $calendarId)
            {
                $object= $calendar;
                break;
            }
        }
        return $object;
    }


    public function ModifyCalendar($id, Calendar $calendarNew)
    {
        $index=0;
        
        foreach($this->calendarList as $calendar)
        {
            if($calendar->getId() == $id)
            {
                array_splice($this->calendarList, $index, 1, array($calendarNew)); 
            }
            $index++;
        }
    }   
    
    public function DeleteCalendar($calendarId)
    {
        $i= 0;

        foreach($this->calendarList as $calendar)
        {
            if($calendar->getId() == $calendarId)
            {
                unset($this->calendarList[$i]);
                break;
            }
            $i++;
        }
        $this->calendarList= array_values($this->calendarList);
    }
}

?>