<?php 
namespace Controllers;

use Dao\DaoEventSeatPDO as DaoEventSeatPDO;
use Dao\DaoCalendarPDO as DaoCalendarPDO;
use Dao\DaoSeatTypePDO as DaoSeatTypePDO;


use Model\EventSeat as EventSeat;
use Model\Calendar as Calendar; 
use Model\SeatType as SeatType;

class ControllerEventSeat
{
    private $eventSeatDao;
    private $calendarDao;
    private $seatTypeDao;

    public function __construct()
    {
        
        $this->eventSeatDao= new DaoEventSeatPDO();
        $this->calendarDao= new DaoCalendarPDO();
        $this->seatTypeDao= new DaoSeatTypePDO();
    }

    public function ShowAddEventSeatView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $calendarList=$this->calendarDao->GetAll();
                $setTypeList=$this->seatTypeDao->GetAll();
                if(count($setTypeList) <= 0 ){
                    $message = 'No se encontraron tipos de asientos,
                    por favor ingreselos antes de cargar asientos';
                    require_once(VIEWS_PATH . "viewAddSeatType.php");
                }else{
                    require_once(VIEWS_PATH . "viewAddEventSeat.php");
                }
            }else
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
    
    public function ShowListEventSeatView()
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventSeatList= $this->eventSeatDao->GetAll();
                require_once(VIEWS_PATH . "viewListEventSeat.php");
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
    
    public function ShowDeleteEventSeatCalendarView($message=" ")
    { 
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventSeatList= $this->eventSeatDao->GetAll();
                require_once(VIEWS_PATH . "viewDeleteEventSeatCalendar.php");
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

    public function ShowDeleteEventSeatSeatView(Calendar $oCalendar)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewDeleteEventSeatSeat.php");
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
    
    public function ShowModifyEventSeatView(EventSeat $oEventSeat, $message= " ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewModifyEventSeat.php");
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

    public function ShowModifyEventSeatSeatView(Calendar $oCalendar, $message= " ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewModifyEventSeatSeat.php");
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
    
    public function ShowModifyeventSeatListView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventSeatList= $this->eventSeatDao->GetAll();
                require_once(VIEWS_PATH . "viewModifyEventSeatList.php");
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

    public function Add($calendarId= null, $seatTypeId= null, $quantity, $price)
    //$calendarId= null para que no de error en el call_user_func antes de entrar al add, si es que no hay 
    //ningun calendar cargado  
    {
        try
        {
            $message= "";
            $contAnt= 0;
            $contPost= 0;
            $exist= false; //para controlar que a un mismo calendario no se le agregue el mismo tipo de asiento mas de una vez
            $seatSum= 0; //para controlar que la sumatoria de las cantidades de los tipos de asiento, no superen la cantidad maxima del typePlace del calendario
            
            //echo "calendar id: " .$calendarId, " seatType id: ". $seatTypeId. " Quantity: ". $quantity. " precio: ". $price;
            if((isset($price))&&(isset($quantity))&&(isset($calendarId))&&(isset($seatTypeId)))
            {   
                if((!empty($price))&&(!empty($quantity))&&(!empty($calendarId))&&(!empty($seatTypeId)))
                {   
                    foreach($this->eventSeatDao->GetAll() as $oEventSeat)
                    {
                        $oCalendar= $oEventSeat->getCalendar();
                        $oSeatType= $oEventSeat->getSeatType();
                        if(($oCalendar->getId() == $calendarId) && ($oSeatType->getId() == $seatTypeId))
                        {//controla que a un mismo calendario no se le agregue el mismo tipo de asiento mas de una vez
                            $exist= true;
                        }
                    }

                    $eventSeat= new EventSeat();
                    $eventSeat->setPrice($price);
                    $eventSeat->setQuantity($quantity);
                    $eventSeat->setRemains($quantity);//cuando creo hay la misma cantidad de silas libres que las que hay en total
                    $calendarAux= $this->calendarDao->GetByCalendarId($calendarId);
                    if(isset($calendarAux))
                    {
                        $eventSeat->setCalendar($calendarAux);
                    }

                    $seatTypeAux= $this->seatTypeDao->GetBySeatTypeId($seatTypeId);
                    if(isset($seatTypeAux))
                    {
                        $eventSeat->setSeatType($seatTypeAux);
                    }
                    
                    $eventSeatList= $this->eventSeatDao->GetByCalendarId($calendarId);
                    $placeEvent= $calendarAux->getPlaceEvent();


                    foreach($eventSeatList as $oEventSeat)
                    {
                        $seatSum= $seatSum + $oEventSeat->getQuantity();
                    }
                    //echo "seatSum: " .$seatSum;
                    //echo "placeEvent: ". $placeEvent->getCapacity();
                    $contAnt= count($this->eventSeatDao->GetAll());
                    /* echo "<pre>";
                     var_dump($eventSeat);
                     echo "</pre>";*/

                    if(!$exist)
                    {
                        if(($seatSum + $quantity) < $placeEvent->getCapacity())
                        {
                            $this->eventSeatDao->AddEventSeat($eventSeat);
                    
                            $contPost= count($this->eventSeatDao->GetAll());
    
                            if($contAnt < $contPost)
                            {
                                $message= "agregado correctamente";
                            }
                            else
                            {
                                $message= "error de carga!!";
                            }
                        }
                        else
                        {
                            $freeSpace= $placeEvent->getCapacity() - $seatSum;
                            $message= "se ha superado la capacidad del lugar, la cantidad maxima restante de asientos es de: ". $freeSpace . " lugares";
                        }
                       
                    }
                    else
                    {
                        $message= "ya existe ese tipo de asiento e el calendario";
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
           $this->ShowAddEventSeatView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }
        
    public function DeleteByCalendarSelection($calendarId)
    {
        try
        {
            $oCalendar= new Calendar();
            $oCalendar= $this->calendarDao->GetByCalendarId($calendarId);
    
            $this->ShowDeleteEventSeatSeatView($oCalendar);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }

    public function Delete($eventSeatId)
    {
        try
        {
            $message="";
            $contAnt= 0;
            $contPost= 0;
    
            if((isset($eventSeatId)) && (!empty($eventSeatId)))
            {
                $contAnt= count($this->eventSeatDao->GetAll());
               
                $this->eventSeatDao->DeleteEventSeat($eventSeatId);
    
                $contPost= count($this->eventSeatDao->GetAll());
                
                if($contAnt > $contPost)
                {
                    $message= "eliminado correctamente!!";
                }
                else
                {
                    $message= "error eliminando!!";
                }
            }
            else
            {
                $message= "parametros incorrectos, no se elimino el registro";
            }
            $this->ShowDeleteEventSeatCalendarView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }

    public function modifyList($calendarId)
    {
        try
        {
            $oCalendar= $this->calendarDao->GetByCalendarId($calendarId);
            
            if(isset($oCalendar))
            {
                $message="";
                $this->ShowModifyEventSeatSeatView($oCalendar, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }

    public function modifySeat($eventSeatId)
    {
        try
        {
            $oEventSeat= $this->eventSeatDao->GetByEventSeatId($eventSeatId);
            
            if(isset($oEventSeat))
            {
                $message="";
                $this->ShowModifyEventSeatView($oEventSeat, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }

    public function Modify($id, $price, $quantity, $remains, $calendarId, $seatTypeId)
    {
        try
        {
            if((isset($id))&&(isset($price))&&(isset($quantity))&&(isset($remains))&&(isset($calendarId))&&(isset($seatTypeId)))
            {
                if((!empty($id))&&(!empty($price))&&(!empty($quantity))&&(!empty($remains))&&(!empty($calendarId))&&(!empty($seatTypeId)))
                {
    
                    $eventSeatNew= new EventSeat();
                    $eventSeatNew->setId($id);
                    $eventSeatNew->setPrice($price);
                    $eventSeatNew->setQuantity($quantity);
                    $eventSeatNew->setRemains($remains);
                    
                    $calendar= $this->calendarDao->GetByCalendarId($calendarId);
                    $seatType= $this->seatTypeDao->GetBySeatTypeId($seatTypeId);
    
                    $eventSeatNew->setCalendar($calendar);
                    $eventSeatNew->setSeatType($seatType);
    
                    $this->eventSeatDao->ModifyEventSeat($id, $eventSeatNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyEventSeatListView($message);
                }
                else
                {
                    $oEventSeat= $this->eventSeatDao->GetByEventSeatId($id);
            
                    if(isset($oEventSeat))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyEventSeatView($oEventSeat, $message);
                    }
                }
            }
            else
            {
                $oEventSeat= $this->eventSeatDao->GetByEventSeatId($id);
            
                if(isset($oEventSeat))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyEventSeatView($oEventSeat, $message);
                }
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }   
    }


}

?>