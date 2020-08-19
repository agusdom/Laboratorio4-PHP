<?php
    namespace DAO;

    use Models\Beer as Beer;
    use \Exception as Exception;

    class BeerDAOList implements IBeerDAO
    {
        private $beerList;

        public function __construct()
        {
            if(!isset($_SESSION["beerList"]))
                $_SESSION["beerList"] = array();
            
            $this->beerList = &$_SESSION["beerList"];
        }

        public function Add(Beer $beer)
        {
            array_push($this->beerList, $beer);            
        }

        public function GetAll()
        {
            return $this->beerList;
        }

        public function GetByCode($beerCode)
        {
            $beer = null;

            foreach($this->beerList as $aux)
            {
                if($aux->getBeerCode() == $beerCode)
                {
                    $beer = $aux;
                    break;
                }
            }

            return $beer;
        }

        public function GetByTypeCode($beerTypeCode)
        {
            $beer = null;

            foreach($this->beerList as $aux)
            {
                if($aux->getBeerType()->getBeerTypeCode() == $beerTypeCode)
                {
                    $beer = $aux;
                    break;
                }
            }

            return $beer;
        }

        public function Delete($beerCode)
        {
            $i = 0;

            foreach($this->beerList as $beer)
            {
                if($beer->getBeerCode() == $beerCode)
                {
                    unset($this->beerList[$i]);
                    break;
                }

                $i++;
            }

            $this->beerList = array_values($this->beerList);
        }

        public function ShowException()
        {
            try
            {
                throw new Exception('Error de tipo List.');
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }
    }
?>