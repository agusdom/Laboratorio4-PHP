<?php
namespace Controllers;

use Dao\DaoBeerTypeList as DaoBeerTypeList;
use Dao\DaoBeerList as DaoBeerList;


class ControllerMain
{
    private $beerTypeList;
    private $beerList;

    public function __construct()
    {
        $this->beerTypeList= new DaoBeerTypeList();
        $this->beerList= new DaoBeerList();
    }

    public function Index()
    {        
        require_once(VIEWS_PATH ."viewMain.php");
    }       
}

?>