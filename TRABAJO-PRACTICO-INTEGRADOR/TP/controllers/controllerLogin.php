<?php
#los usuarios necesitan tener pdo?
    #si necesitan pdo, tengo que poner los metodos add modify... etc?
        #
namespace Controllers;

use Dao\DaoEventPDO as DaoEventPDO;
use Dao\DaoUserList as DaoUserList;
use Dao\DaoUserPDO as DaoUserPDO;
use Dao\DaoRolList as DaoRolList;
use Dao\DaoRolPDO as DaoRolPDO;
use Dao\DaoEventSeatPDO as DaoEventSeatPDO;



use Model\EventSeat as EventSeat;
use Model\Event as Event;
use Model\User as User;
use Model\Rol as Rol;

class ControllerLogin
{
    private $eventDao;
    private $userList;
    private $rolList;
    private $eventSeatDao;

    public function __construct()
    {
        //$this->userList= new DaoUserList();
        $this->eventDao= new DaoEventPDO();
        $this->userList= new DaoUserPDO();
        $this->rolList= new DaoRolPDO();
        $this->eventSeatDao= new DaoEventSeatPDO();
    }

    public function Index($message=" ")
    {
        require_once(VIEWS_PATH . "viewLogin.php");
    }

    public function ShowAddArtistView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewAddArtist.php "); 
            }
            else
            {
                $this->Index();
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        }
    }

    public function ShowAddUserView($message=" ")
    { 
        try
        {
            require_once(VIEWS_PATH . "viewSignUp.php ");
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }

    public function ShowUserHomeView()
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventList= $this->eventDao->GetAll();
                require_once(VIEWS_PATH . "viewUserHome.php");
            }
            else
            {
                $this->Index();
            }
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }   
    
    public function Login($email, $password)
    {	
		try
		{
            session_destroy();
            session_start();
            $oUser=$this->userList->GetByEmail($email); 
            #echo $email;
            if(isset($oUser)){ 
                $passwordRegister=$oUser->getPassword();
                
				if($password===$passwordRegister)
				{
                    $_SESSION["userLogged"]= $oUser;
                    
                    $rol= $oUser->getRol();
                    if($rol->getId() == 1) //si el user es admin
                    {
                        $this->ShowAddArtistView("");
                    }
                    else if($rol->getId() == 2) //si el user es cliente
                    {
                        $this->ShowUserHomeView();
                    }

				}
				else {
					$msj="Contraseña incorrecta !";
					
					 echo '<script language="javascript">alert("' . $msj . '");</script>'; 
					$this->index();
				}
            }
            else {
                $msj="Mail incorrecto!";
                
                 echo '<script language="javascript">alert("' . $msj . '");</script>'; 
                $this->index();
            }
        }
		catch(PDOException $e)
		{
			MyDatabaseException($e->getMessage(),$e->getCode());
        }
   
    /*  }else
        $this->ShowAddUserView("");        
    */
    }

    public function Add($name, $lastName, $email, $password)
    {
        try
		{
            $message= "";
            $oUser= null;

            if((isset($name))&&(isset($lastName))&&(isset($email))&&(isset($password)))
            {
                if((!empty($name))&&(isset($lastName))&&(isset($email))&&(isset($password)))
                {
                    $oUser=$this->userList->GetByEmail($email); 
                   
                    if($oUser == null)
                    {
                        //chequea si ya no esta creado
                        $user= new user();
                        $user->setName($name);
                        $user->setLastName($lastName);
                        $user->setEmail($email);
                        $user->setPassword($password);
                        $rolaux= $this->rolList->GetById(2);
                        if(isset($rolaux))
                        {
                            $user->setRol($rolaux);
                        }
                        $this->userList->AddUser($user);
                        $message= "agregado correctamente";
                        $this->Index();  
                    }
                    else
                    {
                        $message = 'El mail ingresado ya se encuentra en uso, por favor ingrese otro';
                        echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                        $this->Index();  
                    }            
                }
                else
                {
                    $message= "valores incorrectos";
                }
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->Index();
        }
    }
}
?>