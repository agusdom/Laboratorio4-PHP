<?php
namespace Dao;

use Model\PlaceEvent as PlaceEvent;

interface IDaoPlaceEvent
{
    function GetAll();
    public function AddPlaceEvent(PlaceEvent $placeEvent);
    public function GetByPlaceEventId($placeEventId);
    function GetByPlaceEventName($name);
    public function ModifyPlaceEvent($id, PlaceEvent $placeEventNew);
    public function DeletePlaceEvent($placeEventName);

}

?>