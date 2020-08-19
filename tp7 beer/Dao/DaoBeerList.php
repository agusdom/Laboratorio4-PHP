<?php
namespace Dao;

use Dao\IDaoBeerList as IDaoBeerList;
use Model\Beer as Beer;

class DaoBeerList implements IDaoBeerList
{
    private $beerList;

    public function __construct()
    {
       if(!isset($_SESSION["beerList"]))
       {
            $_SESSION["beerList"]= array(); 
       }
       $this->beerList= &$_SESSION["beerList"];
    }


    public function GetAll()
    {
        return $this->beerList;
    }


    public function AddBeer(Beer $beer)
    {
        //$this->GetBeerSession(); //no parece necesitar esta sentencia
        array_push($this->beerList, $beer);
    }

    public function GetByBeerId($beerId)
    {
    //busca un objeto en el repositorio por el id de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        $object= null;

        foreach($this->beerList as $beer)
        {
            if($beer->getId() == $beerId)
            {
                $object= $beer;
                break;
            }
        }
        return $object;
    }

    public function GetByBeerName($beerName)
    {
    //busca un objeto en el repositorio por el name de la cerveza
    //devuelve el objeto si lo encuentra, sino devuelve null
        $object= null;

        foreach($this->beerList as $beer)
        {
            if($beer->getName() == $beerName)
            {
                $object= $beer;
                break;
            }
        }
        return $object;
    }

    public function ModifyBeer($id, Beer $beerNew)
    {
        $index=0;
        
        foreach($this->beerList as $beer)
        {
            if($beer->getId() == $id)
            {
                array_splice($this->beerList, $index, 1, array($beerNew)); 
            }
            $index++;
        }
    }   
    
    public function DeleteBeer($beerId)
    {
        $i= 0;

        foreach($this->beerList as $beer)
        {
            if($beer->getId() == $beerId)
            {
                unset($this->beerList[$i]);
                break;
            }
            $i++;
        }
        $this->beerList= array_values($this->beerList);
    }
}

?>