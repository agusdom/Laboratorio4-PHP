<?php 
namespace Model;

use Model\Event as Event;
use Model\PlaceEvent as PlaceEvent;
use Model\Artist as Artist;

class Calendar
{
    private $id;
    private $date;
    private $event;
    private $placeEvent;
    private $artistList= array();

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id= $id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date= $date;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setEvent(Event $event)
    {
        $this->event= $event;
    }

    public function getPlaceEvent()
    {
        return $this->placeEvent;
    }

    public function setPlaceEvent(placeEvent $placeEvent)
    {
        $this->placeEvent= $placeEvent;
    }

    public function getArtistList()
    {
        return $this->artistList;
    }

    public function setArtistList($artistList)
    {
        $this->artistList= $artistList;
    }




}

?>