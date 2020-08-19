<?php
    namespace DAO;

    use Models\BeerType as BeerType;
    use DAO\Connection as Connection;

    class BeerTypeDAOPDO
    {
        private $connection;
        private $tableName = "beertypes";

        public function Add(BeerType $beerType)
        {
            $query = "INSERT INTO ".$this->tableName." (beerTypeCode, name, description, recipe) VALUES (:beerTypeCode, :name, :description, :recipe);";
            
            $parameters["beerTypeCode"] = $beerType->getBeerTypeCode();
            $parameters["name"] = $beerType->getName();
            $parameters["description"] = $beerType->getDescription();
            $parameters["recipe"] = $beerType->getRecipe();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }

        public function GetAll()
        {
            $beerTypeList = array();

            $query = "SELECT * FROM ".$this->tableName;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query);
            
            foreach ($resultSet as $row)
			{                
                $beerType = new BeerType();
                $beerType->setBeerTypeCode($row["beertypecode"]);
                $beerType->setName($row["Name"]);
                $beerType->setDescription($row["Description"]);
                $beerType->setRecipe($row["recipe"]);

				array_push($beerTypeList, $beerType);
			}

            return $beerTypeList;
        }

        public function GetByBeerTypeCode($beerTypeCode)
        {
            $beerType = null;

            $query = "SELECT * FROM ".$this->tableName." WHERE beerTypeCode = :beerTypeCode";

            $parameters["beerTypeCode"] = $beerTypeCode;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            
            foreach ($resultSet as $row)
			{
                $beerType = new BeerType();
                $beerType->setBeerTypeCode($row["beertypecode"]);
                $beerType->setName($row["Name"]);
                $beerType->setDescription($row["Description"]);
                $beerType->setRecipe($row["recipe"]);
            }
                        
            return $beerType;
        }

        public function Delete($beerTypeCode)
        {
            $query = "DELETE FROM ".$this->tableName." WHERE beerTypeCode = :beerTypeCode";
            
            $parameters["beerTypeCode"] = $beerTypeCode;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
    }
?>