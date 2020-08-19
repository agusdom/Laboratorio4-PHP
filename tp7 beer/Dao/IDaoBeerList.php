<?php
namespace Dao;

use Model\Beer as Beer;

interface IDaoBeerList
{
    function GetAll();
    function AddBeer(Beer $beer);
    function GetByBeerId($beerId);
    function GetByBeerName($beerName);
    function ModifyBeer($id, Beer $beerNew);
    function DeleteBeer($beerId);
}

?>