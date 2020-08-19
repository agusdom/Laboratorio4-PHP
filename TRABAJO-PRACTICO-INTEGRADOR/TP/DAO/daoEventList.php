<?php
namespace Dao;

use Dao\IDaoEvent as IDaoEvent;
use Model\Event as Event;

class DaoEventList implements IDaoEvent
{
    private $eventList;

    public function __construct()
    {
       if(!isset($_SESSION["eventList"]))
       {
            $_SESSION["eventList"]= array(); 
       }
       $this->eventList= &$_SESSION["eventList"];
    }


    public function GetAll()
    {
        return $this->eventList;
    }


    public function AddEvent(Event $event)
    {
        $id=0;
        if(!isset($_SESSION["eventId"]))
        {
            $id=1;
            $_SESSION["eventId"]= $id;
        }
        else
        {
            $id= $_SESSION["eventId"];
            $id++;
            $_SESSION["eventId"]= $id;
        }
        $event->setId($id);
        array_push($this->eventList, $event);
    }

    public function GetByEventId($eventId)
    {
    //busca un objeto en el repositorio por el id de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        $object= null;

        foreach($this->eventList as $event)
        {
            if($event->getId() == $eventId)
            {
                $object= $event;
                break;
            }
        }
        return $object;
    }


    public function GetByEventName($eventName)
    {
    //busca un objeto en el repositorio por el name de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        $object= null;

        foreach($this->eventList as $event)
        {
            if($event->getName() == $eventName)
            {
                $object= $event;
                break;
            }
        }
        return $object;
    }

    public function ModifyEvent($id, Event $eventNew)
    {
        $index=0;
        
        foreach($this->eventList as $event)
        {
            if($event->getId() == $id)
            {
                array_splice($this->eventList, $index, 1, array($eventNew)); 
            }
            $index++;
        }
    }   
    
    public function DeleteEvent($eventId)
    {
        $i= 0;

        foreach($this->eventList as $event)
        {
            if($event->getId() == $eventId)
            {
                unset($this->eventList[$i]);
                break;
            }
            $i++;
        }
        $this->eventList= array_values($this->eventList);
    }
}

?>