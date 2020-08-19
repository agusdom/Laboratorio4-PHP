<?php
namespace Dao;

use Model\PlaceEvent as PlaceEvent;
use Dao\IDaoPlaceEvent as IDaoPlaceEvent;

class DaoPlaceEventList implements IDaoPlaceEvent
{
    private $placeEventList;
    
    
    public function __construct()
    {
       if(!isset($_SESSION["placeEventList"]))
       {
            $_SESSION["placeEventList"]= array(); 
       }
       $this->placeEventList= &$_SESSION["placeEventList"];
    }

    public function AddPlaceEvent(PlaceEvent $placeEvent)
    {
        $id=0;
        if(!isset($_SESSION["placeEventId"]))
        {
            $id=1;
            $_SESSION["placeEventId"]= $id;
        }
        else
        {
            $id= $_SESSION["placeEventId"];
            $id++;
            $_SESSION["placeEventId"]= $id;
        }
        $placeEvent->setId($id);
        array_push($this->placeEventList, $placeEvent);
    }

    public function GetAll()
    {
        return $this->placeEventList;
    }

    public function GetByPlaceEventId($placeEventId)
    {
        $object= null;

        foreach($this->placeEventList as $placeEvent)
        {
            if($placeEvent->getId() == $placeEventId)
            {
                $object= $placeEvent;
                break;
            }
        }
        return $object;
    }

    public function DeletePlaceEvent($placeEventId)
    {
        $i=0;

        foreach($this->placeEventList as $placeEvent)
        {
            if($placeEvent->getId() == $placeEventId)
            {
                unset($this->placeEventList[$i]);
                break;
            }
            $i++;
        }
        $this->placeEventList= array_values($this->placeEventList);
    }

    public function ModifyPlaceEvent($id, PlaceEvent $placeEventNew)
    {
        $index=0;
        
        foreach($this->placeEventList as $placeEvent)
        {
            if($placeEvent->getId() == $id)
            {
                array_splice($this->placeEventList, $index, 1, array($placeEventNew)); 
            }
            $index++;
        }
    }     
}
?>