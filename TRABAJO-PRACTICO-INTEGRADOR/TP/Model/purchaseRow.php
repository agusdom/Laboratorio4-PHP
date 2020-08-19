<?php 
namespace Model;

use Model\EventSeat as EventSeat;

class PurchaseRow
{
    private $id;
    private $price;
    private $quantity;
    private $eventSeat;
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id= $id;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price= $price;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity= $quantity;
    }

    public function getEventSeat()
    {
        return $this->eventSeat;
    }

    public function setEventSeat(EventSeat $eventSeat)
    {
        $this->eventSeat= $eventSeat;
    }
}

?>