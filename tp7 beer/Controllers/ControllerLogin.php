<?php
namespace Controllers;

use Model\User as User;

class ControllerLogin
{

    public function Index($message= " ")
    {
        require_once(VIEWS_PATH ."viewLogin.php");
    }


    public function Login($email, $password)
    {
        $defaultEmail= "cosme@fulanito.com";
        $defaultPassword= "123";
        $message="";
        $user= new User();
        
        if((isset($email)) && (isset($password)))
        {
            if((!empty($email)) && (!empty($password)))
            {
                if(($defaultEmail == $email) && ($defaultPassword == $password))
                {
                    $user->setEmail($email);
                    $user->setPassword($password);

                    $_SESSION["userLogged"]= $user;

                    require_once(VIEWS_PATH . "viewAddBeerType.php");
                }
                else
                {
                    $message= "email o password incorrectos!!";
                    $this->Index($message);
                }
            }
            else
            {
                $message= "campos vacios";
                $this->Index($message);
            }
        }
        else
        {
            $message= "campos no seteados";
            $this->Index($message);
        }
    }
}

?>