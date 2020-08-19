<?php
namespace Dao;

use Dao\IDaoBeerTypeList as IDaoBeerTypeList;
use Model\BeerType as BeerType;

class DaoBeerTypeList implements IDaoBeerTypeList
{
    private $beerTypeList;

    public function __construct()
    {
        if(!isset($_SESSION["beerTypeList"]))
        {
            $_SESSION["beerTypeList"]= array();
        }
        $this->beerTypeList= &$_SESSION["beerTypeList"];
    }

    function GetAll()
    {
        return $this->beerTypeList;
    }

    public function AddBeerType(BeerType $BeerType)
    {
        array_push($this->beerTypeList, $BeerType);
        $_SESSION["beerTypeList"]= $this->beerTypeList;
    }

    public function GetByBeerTypeId($beerTypeId)
    {
    //busca un objeto en el repositorio por el id de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        
        $object= null;

        foreach($this->beerTypeList as $beerType)
        {
            if($beerType->getId() == $beerTypeId)
            {
                $object= $beerType;
                break;
            }
        }
        return $object;
    }

    public function GetByBeerTypeName($beerTypeName)
    {
    //busca un objeto en el repositorio por el name de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        
        $object= null;

        foreach($this->beerTypeList as $beerType)
        {
            if($beerType->getName() == $beerTypeName)
            {
                $object= $beerType;
                break;
            }
        }
        return $object;
    }

    public function ModifyBeerType($id, BeerType $beerTypeNew)
    {
        $index= 0;

        foreach($this->beerTypeList as $beerType)
        {
            if($beerType->getId() == $id)
            {
                array_splice($this->beerTypeList, $index, 1, array($beerTypeNew));
            }
            $index++;
        }
    }

    public function DeleteBeerType($beerTypeId)
    {
        $i= 0;

        foreach($this->beerTypeList as $beerType)
        {
            if($beerType->getId() == $beerTypeId)
            {
                unset($this->beerTypeList[$i]);
                break;
            }
            $i++;
        }
        $this->beerTypeList= array_values($this->beerTypeList);
        $_SESSION["beerTypeList"]= $this->beerTypeList;
    }
}

?>