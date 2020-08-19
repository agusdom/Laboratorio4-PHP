<?php
namespace Dao;

use Model\BeerType as BeerType;

interface IDaoBeerTypeList
{
    function GetAll();
    public function AddBeerType(BeerType $BeerType);
    public function GetByBeerTypeId($beerTypeId);
    public function GetByBeerTypeName($beerTypeName);
    public function ModifyBeerType($id, BeerType $beerTypeNew);
    public function DeleteBeerType($beerTypeName);

}

?>