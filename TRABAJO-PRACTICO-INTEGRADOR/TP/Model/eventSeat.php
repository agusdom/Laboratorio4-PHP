<?php 
namespace Model;

use Model\Calendar as Calendar;
use Model\SeatType as SeatType;

class EventSeat
{
    private $id;
    private $price;
    private $quantity;
    private $remains;
    private $calendar;
    private $seatType;

    public function setId($id)
    {
        $this->id= $id;
    }

    public function getId()
    {
        return $this->id;
    } 

    public function setPrice($price)
    {
        $this->price= $price;
    }

    public function getPrice()
    {
        return $this->price;
    } 

    public function setQuantity($quantity)
    {
        $this->quantity= $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    } 

    public function setRemains($remains)
    {
        $this->remains= $remains;
    }

    public function getRemains()
    {
        return $this->remains;
    } 

    public function setCalendar(Calendar $calendar)
    {
        $this->calendar= $calendar;
    }

    public function getCalendar()
    {
        return $this->calendar;
    } 

    public function setSeatType(SeatType $seatType)
    {
        $this->seatType= $seatType;
    }

    public function getSeatType()
    {
        return $this->seatType;
    } 
}

?>