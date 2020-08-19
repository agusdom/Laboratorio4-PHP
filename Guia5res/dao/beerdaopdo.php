<?php
    namespace DAO;

    use Models\Beer as Beer;
    use Models\BeerType as BeerType;
    use DAO\Connection as Connection;

    class BeerDAOPDO
    {
        private $connection;
        private $tableName = "beers";
        private $tableNameBT = "beertypes";

        public function Add(Beer $beer)
        {
            try
            {
                $query = "INSERT INTO ".$this->tableName." (beerCode, beertypecode, Name, Description, density, origin, price) VALUES (:beerCode, :beertypecode, :Name, :Description, :density, :origin, :price);";
                
                $parameters["beerCode"] = $beer->getBeerCode();
                $parameters["beerTypeCode"] = $beer->getBeerType()->getBeerTypeCode();
                $parameters["Name"] = $beer->getName();
                $parameters["Description"] = $beer->getDescription();
                $parameters["density"] = $beer->getDensity();
                $parameters["origin"] = $beer->getOrigin();
                $parameters["price"] = $beer->getPrice();

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetAll()
        {
            try
            {
                $beerList = array();

                $query = "SELECT b.beercode, b.Name as beerName, b.Description as beerdesc, b.density, b.origin, b.price, bt.beertypecode, bt.Name as beerTypeName, bt.Description as beertypedesc, bt.recipe
                from ".$this->tableName." b 
                inner join ".$this->tableNameBT." bt on b.fk_beerTypeCode = bt.beertypecode
                order by b.beercode;";

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $beer = new Beer();
                    $beer->setBeerCode($row["beercode"]);
                    $beer->setName($row["beerName"]);
                    $beer->setDescription($row["beerdesc"]);
                    $beer->setDensity($row["density"]);
                    $beer->setOrigin($row["origin"]);
                    $beer->setPrice($row["price"]);

                    $beerType = new BeerType();
                    $beerType->setBeerTypeCode($row["beertypecode"]); 
                    $beerType->setName($row["beerTypeName"]);
                    $beerType->setDescription($row["beertypedesc"]);
                    $beerType->setRecipe($row["recipe"]);

                    $beer->setBeerType($beerType);

                    array_push($beerList, $beer);
                }

                return $beerList;
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetByBeerCode($beerCode)
        {
            try
            {
                $beer = null;

                $query = "SELECT * FROM ".$this->tableName." WHERE beerCode = :beerCode";

                $parameters["beerCode"] = $beerCode;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {
                    $beer = new Beer();
                    $beer->setBeerCode($row["beercode"]);
                    $beer->setName($row["Name"]);
                    $beer->setDescription($row["Description"]);
                    $beer->setRecipe($row["recipe"]);
                }
                            
                return $beer;
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function GetByTypeCode($beerTypeCode)
        {
            try
            {
                $beerList = array();

                $query = "SELECT b.beercode, b.Name as beerName, b.Description as beerdesc, b.density, b.origin, b.price, bt.beertypecode, bt.Name as beerTypeName, bt.Description as beertypedesc, bt.recipe
                from ".$this->tableName." b 
                inner join ".$this->tableNameBT." bt on b.fk_beerTypeCode = bt.beertypecode
                where b.fk_beerTypeCode = :beerTypeCode ;";

                $parameters["beerTypeCode"] = $beerTypeCode;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $beer = new Beer();
                    $beer->setBeerCode($row["beercode"]);
                    $beer->setName($row["beerName"]);
                    $beer->setDescription($row["beerdesc"]);
                    $beer->setDensity($row["density"]);
                    $beer->setOrigin($row["origin"]);
                    $beer->setPrice($row["price"]);

                    $beerType = new BeerType();
                    $beerType->setBeerTypeCode($row["beertypecode"]); 
                    $beerType->setName($row["beerTypeName"]);
                    $beerType->setDescription($row["beertypedesc"]);
                    $beerType->setRecipe($row["recipe"]);

                    $beer->setBeerType($beerType);

                    array_push($beerList, $beer);
                }

                return $beerList;
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function Delete($beerCode)
        {
            try
            {
                $query = "DELETE FROM ".$this->tableName." WHERE beerCode = :beerCode";
                
                $parameters["beerCode"] = $beerCode;

                $this->connection = Connection::GetInstance();

                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        public function ShowException()
        {
            try
            {
                $query = "SELECT name, error FROM ".$this->tableName;
            
                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query);
            }
            catch(PDOException $e)
            {
                throw $e;
            }
        }
    }
?>