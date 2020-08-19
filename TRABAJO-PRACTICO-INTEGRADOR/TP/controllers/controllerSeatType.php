<?php
namespace Controllers;
   
use Model\SeatType as SeatType;
use Model\EventSeat as EventSeat;
use Dao\DaoSeatTypeList as DaoSeatTypeList;
use Dao\DaoSeatTypePDO as DaoSeatTypePDO;
use Dao\DaoEventSeatPDO as DaoEventSeatPDO;

class ControllerSeatType
{
    private $seatTypeDao;
    private $eventSeatDao;

    public function __construct()
    {
        $this->seatTypeDao= new DaoSeatTypePDO();
        $this->eventSeatDao= new DaoEventSeatPDO();
    }

    public function ShowAddSeatTypeView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewAddSeatType.php");
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }
    
    public function ShowListSeatTypeView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $seatTypeList= $this->seatTypeDao->GetAll();
                require_once(VIEWS_PATH . "viewListSeatType.php");
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }
    
    public function ShowModifySeatTypeListView($message= " ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $seatTypeList= $this->seatTypeDao->GetAll();
                require_once(VIEWS_PATH . "viewModifySeatTypeList.php");
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }

    public function ShowModifySeatTypeView(SeatType $oSeatType, $message= " ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewModifySeatType.php");
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }
    
    
    public function Add($type)
    {
        try
        {
            $message= "";
            $contAnt= 0;
            $contPost= 0;

            $seatTypeCheck=$this->seatTypeDao->GetBySeatTypeName($type);
            if($seatTypeCheck==null){
            
            if(isset($type))
            {
                if((!empty($type)))
                {           
                    $seatType= new SeatType();
                    $seatType->setType($type);
                    
                    $contAnt= count($this->seatTypeDao->GetAll());

                    $this->seatTypeDao->AddSeatType($seatType);

                    $contPost= count($this->seatTypeDao->GetAll());

                    if($contAnt < $contPost)
                    {
                        $message= "agregado correctamente";
                    }
                    else
                    {
                        $message= "ERROR, No se agrego!!!";
                    }
                }
                else
                {
                    $message= "valores incorrectos";
                }  
            }
            else
            {
                $message= "valores incorrectos";
            }
        }
            $message="El Tipo de plaza ingresado ya se encuentra en la base de datos";

        }
        catch(Exception $ex)
        {
            echo $ex;
        }
        $this->ShowListSeatTypeView($message);
        
    }

    public function Delete($seatTypeId)
    {
        try
        {  
            if((isset($seatTypeId)) && (!empty($seatTypeId)))
            {
                $seatTypeList= $this->eventSeatDao->GetBySeatTypeId($seatTypeId);
                
                if(count($seatTypeList) == 0)
                {
                    $message="";
                    $contAnt=0;
                    $contPost=0;

                    $contAnt= count($this->seatTypeDao->GetAll());
                    
                    if($contAnt > 0)
                    {
                        $this->seatTypeDao->DeleteSeatType($seatTypeId);
                    }
                    
                    $contPost= count($this->seatTypeDao->GetAll());

                    if($contPost < $contAnt)
                    {
                        $message= "eliminado exitosamente";
                    }
                    else
                    {
                        $message= "error, no se pudo eliminar";
                    }
                }
                else
                {
                    $message= "La plaza que intenta eliminar esta asociada en algun calendario.";
                }
                
            }
            else
            {
                $message= "parametros incorrectos";
            }
            $this->ShowListSeatTypeView($message);
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
        
    }

    public function modifyList($id)
    {
        try
        {
            $oSeatType= $this->seatTypeDao->GetBySeatTypeId($id);
        
            if(isset($oSeatType))
            {
                $message="";
                $this->ShowModifySeatTypeView($oSeatType, $message);
            }
            else
            {
                $message= "error";
                $this->ShowModifySeatTypeView($message);
            }
        }
        catch(Exception $ex)
        {
            echo $ex;
        }

    }

    public function Modify($id, $type)
    {
        try
        {
            if(isset($id)&&isset($type))
            {
                if(!empty($id)&&!empty($type))
                {           
                    $seatTypeNew= new SeatType();
                    $seatTypeNew->setId($id);
                    $seatTypeNew->setType($type);
                    
                    $this->seatTypeDao->ModifySeatType($id, $seatTypeNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifySeatTypeListView($message);
                }
                else
                {
                    $oSeatType= $this->seatTypeDao->GetBySeatTypeId($id);
            
                    if(isset($oSeatType))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifySeatTypeView($oSeatType, $message);
                    }
                }
            }
            else
            {
                $oSeatType= $this->seatTypeDao->GetBySeatTypeId($id);
            
                if(isset($oSeatType))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifySeatTypeView($oSeatType, $message);
                }
            } 
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
    }
}
    

?>
 