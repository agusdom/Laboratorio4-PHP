<?php
namespace Dao;

use \Exception as Exception;
use Model\User as  User;
use Dao\Connection as Connection;
use Dao\IDaoUser as IDaoUser;

class DaoUserPDO implements IDaoUser
{
    private $tableUser= "users";
    private $connection;

    public function __construct()
    {
        $this->connection= Connection::GetInstance();
    }

    public function GetUserByEmail($email)
    {

        $query= "SELECT userId, email, password FROM ".$this->tableUser." WHERE email= :emailSearch;";
        $parameters= array();
        $parameters["emailSearch"]= $email;

        $resulset= $this->connection->Execute($query, $parameters);

        $user= null;

        foreach($resulset as $row)
        {
            $user= new User();
            $user->setUserId($row["userId"]);
            $user->setEmail($row["email"]);
            $user->setPassword($row["password"]);
        }
        return $user;

    }
}

?>