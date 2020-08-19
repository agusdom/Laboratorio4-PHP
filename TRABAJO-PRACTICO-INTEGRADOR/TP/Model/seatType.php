<?php
namespace Model;

class SeatType
{

    private $id;
    private $type;
     
    public function getId()
     {
        return $this->id;
     }

    public function setId($id)
    {
    $this->id= $id;
    }

    public function setType($type)
    {
        $this->type= $type;
    }

    public function getType()
    {
        return $this->type;
    }


}
?>