<?php 
namespace Controllers;

use Dao\DaoRolPDO as DaoRolPDO;
use Dao\DaoUserList as DaoUserList;
use Dao\DaoUserPDO as DaoUserPDO;
use Model\Rol as Rol;

class ControllerRol
{
    private $rolDao;
    private $userDao;

    public function __construct()
    {
        $this->rolDao= new DaoRolPDO();
        $this->userDao= new DaoUserPDO();

    }

    public function ShowAddRolView($message= " ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewAddRol.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function ShowListRolView()
    {
        try
        {
            require_once(VIEWS_PATH . "viewListRol.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function ShowDeleteRolView($message= " ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewDeleteRol.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function ShowModifyRolListView($message= " ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewModifyRolList.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function ShowModifyRolView($oRol, $message= " ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewModifyRol.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function Add($name, $description)
    {
        try
        {
            if((isset($name))&&(isset($description)))
            {
                if((!empty($name))&&(!empty($description)))
                {
                    $message="";
                    $contAnt=0;
                    $contPost=0;
    
                    $Rol= new Rol();
                    $Rol->setName($name);
                    $Rol->setDescription($description);
                    
                    $contAnt= count($this->rolDao->GetAll());
                    
                    $this->rolDao->AddRol($Rol);
                    
                    $contPost= count($this->rolDao->GetAll());
                    if($contAnt < $contPost)
                    {
                        $message= "agregado correctamente!!";
                    }
                    else
                    {
                        $message= "error de carga!!";
                    }
                }
                else
                {
                    $message= "error de parametros!!";
                }
            }
            else
                {
                    $message= "error de parametros!!";
                }
            $this->ShowAddRolView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function ModifyList($id)
    {
        try
        {
            $oRol= $this->rolDao->GetByRolId($id);
    
            if(isset($oRol))
            {
                $message= "";
                $this->ShowModifyRolView($oRol, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }

    public function Modify($id, $name, $description)
    {
        
        try
        {
            if((isset($id))&&(isset($name))&&(isset($description)))
            {
                if((!empty($id))&&(!empty($name))&&(!empty($description)))
                {
                    $message= "";
    
                    $RolNew= new Rol();
                    $RolNew->setId($id);
                    $RolNew->setName($name);
                    $RolNew->setDescription($description);
    
                    $this->rolDao->ModifyRol($id, $RolNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyRolListView($message);
                }
                else
                {
                    $oRol= $this->rolDao->GetByRolId($id);
                    if(isset($oRol))
                    {
                        $message= "error, algun campo esta vacio";
                        $this->ShowModifyRolView($oRol, $message);
                    }
                }
            }
            else
            {
                $oRol= $this->rolDao->GetByRolId($id);
                if(isset($oRol))
                {
                    $message= "error, algun campo no esta seteado";
                    $this->ShowModifyRolView($oRol, $message);
                }
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }


    public function Delete($id)
    {
        try
        {
            if((isset($id))&&(!empty($id)))
            {
                $message="";
                $contAnt=0;
                $contPost=0;
                $delete= true;
    
                foreach($this->userDao->GetAll() as $User)
                {
                    if($User->getRol()->getId() == $id)
                    {
                        $delete= false;
                        break;
                    }
                }
                if($delete)
                {
                    $contAnt= count($this->rolDao->GetAll());
                    $this->rolDao->DeleteRol($id);
                    $contPost= count($this->rolDao->GetAll());
        
                    if($contAnt > $contPost)
                    {
                        $message= "eliminado correctamente!!";
                    }
                    else
                    {
                        $message= "error, no se pudo eliminar";
                    }
                }
                else
                {
                    $message= "la categoria que intenta eliminar tiene Useros asociados";
                } 
            }
            else
            {
                $message= "error, valores incorrectos";
            }
    
            $this->ShowDeleteRolView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewLogin.php");
        } 
    }
    
}
?>