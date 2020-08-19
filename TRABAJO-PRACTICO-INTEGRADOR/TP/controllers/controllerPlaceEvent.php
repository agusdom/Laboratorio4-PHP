<?php
namespace Controllers;
   
use Model\PlaceEvent as PlaceEvent;
use Model\Calendar as Calendar;
use Dao\DaoPlaceEventList as DaoPlaceEventList;
use Dao\DaoPlaceEventPDO as DaoPlaceEventPDO;
use Dao\DaoCalendarPDO as DaoCalendarPDO;

class ControllerPlaceEvent
{
    private $placeEventDao;
    private $calendarDao;

    public function __construct()
    {
        //$this->placeEventDao= new DaoPlaceEventList();
        $this->placeEventDao= new DaoPlaceEventPDO();
        $this->calendarDao= new DaoCalendarPDO();
    }

    public function ShowAddPlaceEventView($message=" ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewAddPlaceEvent.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        } 
    }
    
    public function ShowListPlaceEventView($message=" ")
    {
        try
        {
            $placeEventList= $this->placeEventDao->GetAll();
            require_once(VIEWS_PATH . "viewListPlaceEvent.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        } 
    }
    
    public function ShowModifyPlaceEventView(PlaceEvent $oPlaceEvent, $message= " ")
    {
        try
        {
            require_once(VIEWS_PATH . "viewModifyPlaceEvent.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        } 
    }
    
    public function ShowModifyPlaceEventListView($message=" ")
    {
        try
        {
            $placeEventList= $this->placeEventDao->GetAll();
            require_once(VIEWS_PATH . "viewModifyPlaceEventList.php");
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        } 
    }


    public function Add($name, $capacity)
    {
        try
        {
            $message= "";

            $placeEventcheck= $this->placeEventDao->GetByPlaceEventName($name);
            if($placeEventcheck==null){

            if((isset($name))&&(isset($capacity)))
            {
                if((!empty($name))&&(isset($capacity)))
                {           
                    $placeEvent= new PlaceEvent();
                    $placeEvent->setName($name);
                    $placeEvent->setCapacity($capacity);
                    
                    $this->placeEventDao->AddPlaceEvent($placeEvent);
                    
                    $message= "agregado correctamente";
                    
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
            }else
                $message="El lugar ingresado ya se encuentra en la base de datos";
        }
        catch(Exception $ex)
        {
            echo $ex;
        }
        $this->ShowAddPlaceEventView($message);
    }

    public function Delete($placeEventId)
    {
        try
        {
            $message="";
            $contAnt=0;
            $contPost=0;
        
            if((isset($placeEventId)) && (!empty($placeEventId)))
            {
                $calendar= $this->calendarDao->GetByPlaceEventId($placeEventId);
                if($calendar == null)
                {
                    $contAnt= count($this->placeEventDao->GetAll());
                
                    if($contAnt > 0)
                    {
                        $this->placeEventDao->DeletePlaceEvent($placeEventId);
                    }
                    
                    $contPost= count($this->placeEventDao->GetAll());

                    if($contPost < $contAnt)
                    {
                        $message= "eliminado exitosamente";
                    }
                    else
                    {
                        $message= "error, no se encontro el PlaceEventa";
                    }
                    }
                else
                {
                    $message= "El lugar que intenta eliminar esta asociado en algun calendario.";
                }
                
            }
            else
            {
                $message= "parametros incorrectos";
            }
            $this->ShowListPlaceEventView($message);
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
            $oPlaceEvent= $this->placeEventDao->GetByPlaceEventId($id);
        
            if(isset($oPlaceEvent))
            {
                $message="";
                $this->ShowModifyPlaceEventView($oPlaceEvent, $message);
            }
            else
            {
                $message= "error";
                $this->ShowModifyPlaceEventListView($message);
            }
        }
        catch(Exception $ex)
        {
            echo $ex;
        }

    }

    public function Modify($id, $name, $capacity)
    {
        try
        {
            if((isset($id))&&(isset($name))&&(isset($capacity)))
            {
                if((!empty($id))&&(!empty($name))&&(isset($capacity)))
                {           
                    $placeEventNew= new PlaceEvent();
                    $placeEventNew->setId($id);
                    $placeEventNew->setName($name);
                    $placeEventNew->setCapacity($capacity);

                    $this->placeEventDao->ModifyPlaceEvent($id, $placeEventNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyPlaceEventListView($message);
                }
                else
                {
                    $oPlaceEvent= $this->placeEventDao->GetByPlaceEventId($id);
            
                    if(isset($oPlaceEvent))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyPlaceEventView($oPlaceEvent, $message);
                    }
                }
            }
            else
            {
                $oPlaceEvent= $this->placeEventDao->GetByPlaceEventId($id);
            
                if(isset($oPlaceEvent))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyPlaceEventView($oPlaceEvent, $message);
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
 