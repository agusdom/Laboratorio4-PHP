<?php
namespace controllers;

use \Exception  as Exception;
use Model\User as User;
use Dao\daoUserPDO as daoUserPDO;

class LoginController
{
    private $userDao;

    public function __construct()
    {
        $this->userDao= new DaoUserPDO;
    }

    public function Index($message="")
    {
        try
        {
            require_once(VIEWS_PATH."index.php");
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function showClientListView()
    {
        try
        {
            require_once(VIEWS_PATH."client-list.php");
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function LogIn($email, $password)
    {
        try
        {
            $message="";

            if(isset($email) && isset($password))
            {
                if(!empty($email) && !empty($password))
                {
                    $user= $this->userDao->GetUserByEmail($email);
                    
                    if(isset($user))
                    {
                        if($user->getPassword() == $password)
                        {
                            $_SESSION["userLogged"]= $user;
                            $this->showClientListView();
                        }
                    }
                    else
                    {
                        $message= "email incorrecto";
                        $this->index($message);
                    }
                }
                else
                {
                    $message= "error, valores vacios";
                    $this->index($message);
                }

            }
            else
            {
                $message= "error en algun valor";
                $this->index($message);
            }
           

           
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function LogOut()
    {
        try
        {
            session_destroy();
            require_once(VIEWS_PATH."index.php");
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }
}


?>