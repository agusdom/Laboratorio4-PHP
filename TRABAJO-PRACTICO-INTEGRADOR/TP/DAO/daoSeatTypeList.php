<?php
namespace Dao;

use Dao\IDaoseatType as IDaoseatType;
use Model\seatType as seatType;

class DaoseatTypeList implements IDaoseatType
{
    private $seatTypeList;

    public function __construct()
    {
       if(!isset($_SESSION["seatTypeList"]))
       {
            $_SESSION["seatTypeList"]= array(); 
       }
       $this->seatTypeList= &$_SESSION["seatTypeList"];
    }


    public function GetAll()
    {
        return $this->seatTypeList;
    }


    public function AddseatType(seatType $seatType)
    {
        $id=0;
        if(!isset($_SESSION["seatTypeId"]))
        {
            $id=1;
            $_SESSION["seatTypeId"]= $id;
        }
        else
        {
            $id= $_SESSION["seatTypeId"];
            $id++;
            $_SESSION["seatTypeId"]= $id;
        }
        $event->setId($id);
        array_push($this->seatTypeList, $seatType);
    }

    public function GetByseatTypeId($seatTypeId)
    {
        $object= null;

        foreach($this->seatTypeList as $seatType)
        {
            if($seatType->getId() == $seatTypeId)
            {
                $object= $seatType;
                break;
            }
        }
        return $object;
    }

    public function GetByseatType($seatType)
    {
    
        $object= null;

        foreach($this->seatTypeList as $seatType)
        {
            if($seatType->getId() == $seatTypeId)
            {
                $object= $seatType;
                break;
            }
        }
    
        return $object;
    }

    public function ModifyseatType($id, seatType $seatTypeNew)
    {
        $index=0;
        
        foreach($this->seatTypeList as $seatType)
        {
            if($seatType->getId() == $id)
            {
                array_splice($this->seatTypeList, $index, 1, array($seatTypeNew)); 
            }
            $index++;
        }
    }   
    
    public function DeleteseatType($seatTypeId)
    {
        $i= 0;

        foreach($this->seatTypeList as $seatType)
        {
            if($seatType->getId() == $seatTypeId)
            {
                unset($this->seatTypeList[$i]);
                break;
            }
            $i++;
        }
        $this->seatTypeList= array_values($this->seatTypeList);
    }
}

?>