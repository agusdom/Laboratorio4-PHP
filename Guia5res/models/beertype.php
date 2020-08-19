<?php
    namespace Models;

    class BeerType
    {
        private $beerTypeCode;
        private $name;
        private $description;
        private $recipe;

        public function getBeerTypeCode()
        {
            return $this->beerTypeCode;
        }

        public function setBeerTypeCode($beerTypeCode)
        {
            $this->beerTypeCode = $beerTypeCode;
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

        public function getRecipe()
        {
            return $this->recipe;
        }

        public function setRecipe($recipe)
        {
            $this->recipe = $recipe;
        }
    }
?>