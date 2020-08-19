<?php 
    namespace Models;

USE Models\BeerType as BeerType;

    class Beer
    {
        private $beerCode;
        private $name;
        private $density;
        private $description;
        private $price;
        private $origin;
        private $beerType;

        public function getBeerCode()
        {
            return $this->beerCode;
        }

        public function setBeerCode($beerCode)
        {
            $this->beerCode = $beerCode;
        }

        public function getName()
        {
            return $this->name;
        }

        public function setName($name)
        {
            $this->name = $name;
        }

        public function getDescription()
        {
            return $this->description;
        }

        public function setDescription($description)
        {
            $this->description = $description;
        }

        public function getDensity()
        {
            return $this->density;
        }

        public function setDensity($density)
        {
            $this->density = $density;
        }

        public function getPrice()
        {
            return $this->price;
        }

        public function setPrice($price)
        {
            $this->price = $price;
        }

        public function getOrigin()
        {
            return $this->origin;
        }

        public function setOrigin($origin)
        {
            $this->origin = $origin;
        }

        public function getBeerType()
        {
            return $this->beerType;
        }

        public function setBeerType(BeerType $beerType)
        {
            $this->beerType = $beerType;
        }
    }
?>