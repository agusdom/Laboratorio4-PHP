<?php

namespace Controllers;

use \Exception as Exception;
use Dao\DaoEventPDO as DaoEventPDO;
use Dao\DaoEventSeatPDO as daoEventSeatPDO;
use Dao\DaoCalendarPDO as DaoCalendarPDO;
use Dao\daoArtistPDO as daoArtistPDO;
use Dao\daoCategoryPDO as daoCategoryPDO;
//use Dao\DaoUserPDO as DaoUserPDO;
//use Dao\DaoRolPDO as DaoRolPDO;

use Model\Event as Event;
use Model\EventSeat as EventSeat;
use Model\ Calendar as Calendar;
use Model\Artist as Artist;
use Model\Category as Category;
//use Model\User as User;
//use Model\Rol as Rol;

class ControllerHome
{
    private $eventDao;
    private $eventSeatDao;
    private $artistDao;
    private $categoryDao;
    //private $userDao;
    //private $rolDao;

    public function __construct()
    {
        $this->eventDao= new DaoEventPDO();
        $this->eventSeatDao= new daoEventSeatPDO();
        $this->artistDao= new daoArtistPDO();
        $this->categoryDao= new daoCategoryPDO();
        //$this->userDao= new DaoUserPDO();
        //$this->rolDao= new DaoRolPDO();
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

    public function ShowEventSeatCalendarView($eventSeatArray)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewUserEventSeatCalendar.php "); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
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

    public function ShowEventSeatSeatView($eventSeatArray)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewUserEventSeatSeat.php "); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
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
    
    public function ShowUserFilterListView($eventList= null , $message= "")
    {
        try
        {   
            
            if(isset($_SESSION["userLogged"])){

                if(($eventList == null) && ($message != ""))
                {
                    $eventList= $this->eventDao->GetAllByDate();
                }
                elseif(($eventList == null) && ($message == ""))
                {
                    $message= "no se encontraron resultados validos";
                }
                $artistList= $this->artistDao->GetArtistWithCalendar();
                $categoryList= $this->categoryDao->GetAllWithCalendar();

                require_once(VIEWS_PATH . "viewUserEventFilter.php"); 
            }
            else
            {
                require_once(VIEWS_PATH . "viewLogin.php");
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

    public function DisplayEventSeatCalendars($eventId)
    {
        try
        {
            $eventSeatArray= $this->eventSeatDao->GetByEventId($eventId); //devuelve una lista de eventSeats cuyo calendario asociado tenga una event con el id dado

            $this->ShowEventSeatCalendarView($eventSeatArray);
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        }
    }

    public function DisplayEventSeatSeats($calendarId)
    {
        try
        {
            $eventSeatArray= $this->eventSeatDao->GetByCalendarId($calendarId);
    
            $this->ShowEventSeatSeatView($eventSeatArray);
        } 
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        }
    }

    public function FilterEvent($artistId= 0, $categoryId= 0, $date1= "", $date2= "")
    {
        try
        {
            $message= "";
            $eventList= null;

            if(($artistId != "") && ($categoryId != ""))
            {
                $message= "elegir solo un filtro por vez";
            }
            elseif(($artistId == "") && ($categoryId == "") && ($date1 == "") && ($date2 == "") )
            {
                $message= "elegir uno de los filtros";
            }
            elseif(($artistId == "") && ($categoryId == "") && (($date1 != "") || ($date2 != "")))
            {
                if(($date1 != "") && ($date2 != ""))
                {
                    $message= "Se filtro entre las fechas: ".$date1. " y ".$date2;
                }
                elseif(($date1 != "") && ($date2 == ""))
                {
                    $message= "Se filtro desde la fecha: ".$date1;
                }
                elseif(($date1 == "") && ($date2 != ""))
                {
                    $message= "Se filtro hasta la fecha: ".$date2;
                }
                $eventList= $this->eventDao->GetByBetweenDates($date1, $date2);
                
            }
            elseif($artistId != "") // elegi un filtro de artista
            {  
                $eventList= $this->eventDao->GetEventByArtistId($artistId, $date1, $date2);
                
                if($eventList != null) //si es null la busqueda no arrojo resultados se envia un mensaje desde ShowUserFilterListView
                {
                    if(($date1 != "") && ($date2 != ""))
                    {
                        $message= "Se filtro por artistas entre fechas: ".$date1. " y ".$date2;
                    }
                    elseif(($date1 != "") && ($date2 == ""))
                    {
                        $message= "Se filtro por artistas desde la fecha: ".$date1;
                    }
                    elseif(($date1 == "") && ($date2 != ""))
                    {
                        $message= "Se filtro por artistas hasta la fecha: ".$date2;
                    }
                    elseif(($date1 == "") && ($date2 == ""))
                    {
                        $message= "Se filtro por artistas";
                    }
                }
                
            }
            elseif($categoryId != "") // elegi un filtro de categoria
            { 
                $eventList= $this->eventDao->GetEventByCategoryId($categoryId, $date1, $date2);
                
                if($eventList != null) //si es null la busqueda no arrojo resultados se envia un mensaje desde ShowUserFilterListView
                {
                    if(($date1 != "") && ($date2 != ""))
                    {
                        $message= "Se filtro por categorias entre fechas: ".$date1. " y ".$date2;
                    }
                    elseif(($date1 != "") && ($date2 == ""))
                    {
                        $message= "Se filtro por categorias desde la fecha: ".$date1;
                    }
                    elseif(($date1 == "") && ($date2 != ""))
                    {
                        $message= "Se filtro por categorias hasta la fecha: ".$date2;
                    }
                    elseif(($date1 == "") && ($date2 == ""))
                    {
                        $message= "Se filtro por categorias";
                    }
                }
                
            }           

            $this->ShowUserFilterListView($eventList, $message);
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            //echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            //require_once(VIEWS_PATH."viewUserHome.php");
        }

    }
}

    
   