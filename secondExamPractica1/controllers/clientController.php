<?php
namespace controllers;

use \Exception  as Exception;
use Model\Client as Client;
use Model\Category as Category;
use Model\Photo as Photo;
use Dao\daoClientPDO as daoClientPDO;
use Dao\daoCategoryPDO as daoCategoryPDO;

class ClientController
{
    private $clientDao;
    private $categoryDao;

    public function __construct()
    {
        $this->clientDao= new daoClientPDO();
        $this->categoryDao= new daoCategoryPDO();
    }

    public function ShowLoginView($message="")
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

    public function showClientListView($message="")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $clientList= $this->clientDao->GetAll();
                require_once(VIEWS_PATH."client-list.php");
            }
            else
            {
                $this->ShowLoginView();
            }
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function showClientAddView($message="")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categoryList= $this->categoryDao->GetAll();
                require_once(VIEWS_PATH."client-add.php");
            }
            else
            {
                $this->ShowLoginView();
            }
           
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function Add($categoryId, $lastName, $firstName, $dni, $email, $address, $photo= null)
    {
        try
        {
            $photo= $_FILES["photo"];
            echo "hola";
            echo $categoryId. $lastName. $firstName. $dni. $email. $address;
            echo "<br>";
            var_dump($photo);
            echo "<br>";
            $contAnt=0;
            $contPost=0;
            $message="";

            if(isset($_SESSION["userLogged"]))
            {
                if(isset($lastName) && isset($firstName) && isset($dni) && isset($email) && isset($address))
                {
                    if(!empty($lastName) && !empty($firstName) && !empty($dni) && !empty($email) && !empty($address))
                    {
                        if($this->clientDao->GetByClientDni($dni)==null)
                        {
                            $category= $this->categoryDao->GetByCategoryId($categoryId);
                            
                            if(isset($category))
                            {
                                $client= new Client();
                                $client->setLastName($lastName);
                                $client->setFirstName($firstName);
                                $client->setDni($dni);
                                $client->setEmail($email);
                                $client->setAddress($address);
                                $client->setcategory($category);
                                $picture= new Photo();
                                $picture->uploadPhoto($photo, "clients");
                                $client->setPicture($picture);

                                $contAnt= count($this->clientDao->GetAll());
                                $this->clientDao->Add($client);
                                $contPost= count($this->clientDao->GetAll());
                                
                                if($contAnt == $contPost)
                                {
                                    $message= "no se agrego";
                                }
                                else
                                {
                                    $message= "agregado correctamente";
                                }

                                $this->showClientAddView($message);

                            }
                        }
                        else
                        {
                            $message= "el cliente ya existe";
                            $this->showClientAddView($message);
                        }
                    }
                    else
                    {
                        $message= "algun valor esta vacio";
                        $this->showClientAddView($message);
                    }
                }
                else
                {
                    $message= "algun valor no esta seteado";
                    $this->showClientAddView($message);
                }
            }
            else
            {
                $this->ShowLoginView();
            }
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }

    public function DeleteClient($dni)
    {
        try
        {
            
            $contAnt=0;
            $contPost=0;
            $message="";

            if(isset($_SESSION["userLogged"]))
            {
                if(isset($dni))
                {
                    if(!empty($dni))
                    {
                        if($this->clientDao->GetByClientDni($dni) != null)
                        {
                            $contAnt= count($this->clientDao->GetAll());
                            $this->clientDao->delete($dni);
                            $contPost= count($this->clientDao->GetAll());
                            $this->showClientListView($message);
                        }
                        else
                        {
                            $message= "no existe un cliente con ese dni";
                            $this->showClientListView($message);
                        }
                    }
                    else
                    {
                        $message= "algun valor esta vacio";
                        $this->showClientListView($message);
                    }
                }
                else
                {
                    $message= "algun valor no esta seteado";
                    $this->showClientListView($message);
                }
            }
            else
            {
                $this->ShowLoginView();
            }     
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }
}

?>