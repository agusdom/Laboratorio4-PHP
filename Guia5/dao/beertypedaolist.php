<?php
    namespace DAO;

    use Models\BeerType as BeerType;

    class BeerTypeDAOList implements IBeerTypeDao
    {
        private $beerTypeList;

        public function __construct()
        {
            if(!isset($_SESSION["BeerTypeList"]))
                $_SESSION["BeerTypeList"] = array();
            
            $this->beerTypeList = &$_SESSION["BeerTypeList"];
        }

        public function Add(BeerType $beerType)
        {
            array_push($this->beerTypeList, $beerType);            
        }

        public function GetAll()
        {
            return $this->beerTypeList;
        }

        public function GetByCode($beerTypeCode)
        {
            $beerType = null;

            foreach($this->beerTypeList as $aux)
            {
                if($aux->getBeerTypeCode() == $beerTypeCode)
                {
                    $beerType = $aux;
                    break;
                }
            }

            return $beerType;
        }

        public function Delete($beerTypeCode)
        {
            $i = 0;

            foreach($this->beerTypeList as $beerType)
            {
                if($beerType->getBeerTypeCode() == $beerTypeCode)
                {
                    unset($this->beerTypeList[$i]);
                    break;
                }

                $i++;
            }

            $this->beerTypeList = array_values($this->beerTypeList);
        }
    }
?>