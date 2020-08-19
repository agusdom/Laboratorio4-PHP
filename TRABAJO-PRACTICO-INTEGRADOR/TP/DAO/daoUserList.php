<?php
namespace Dao;

use Model\User as User;
use Dao\IDaoUser as IDaoUser;

class DaoUserList implements IDaoUser
{
    private $userList;
    
    
    public function __construct()
    {
       if(!isset($_SESSION["userList"]))
       {
            $_SESSION["userList"]= array(); 
       }
       $this->userList= &$_SESSION["userList"];
    }

    public function AddUser(User $user)
    {
        $id=0;
        if(!isset($_SESSION["userId"]))
        {
            $id=1;
            $_SESSION["userId"]= $id;
        }
        else
        {
            $id= $_SESSION["userId"];
            $id++;
            $_SESSION["userId"]= $id;
        }
        $user->setId($id);
        array_push($this->userList, $user);
    }

    public function GetAll()
    {
        return $this->userList;
    }

    public function GetByEmail($email)
    {
        $object= null;

        foreach($this->userList as $user)
        {
            if($artist->getEmail() == $email)
            {
                $object= $artist;
                break;
            }
        }
        return $object;
    }
   
    
}
?>