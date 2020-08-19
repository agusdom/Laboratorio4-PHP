<?php 
namespace Controllers;

use Dao\DaoCalendarList as DaoCalendarList;
use Dao\DaoCalendarPDO as DaoCalendarPDO;
use Dao\DaoEventList as DaoEventList;
use Dao\DaoEventPDO as DaoEventPDO;
use Dao\DaoPlaceEventList as DaoPlaceEventList;
use Dao\DaoPlaceEventPDO as DaoPlaceEventPDO;
use Dao\DaoArtistList as DaoArtistList;
use Dao\DaoArtistPDO as DaoArtistPDO;
use Dao\DaoCategoryPDO as DaoCategoryPDO;


use Model\calendar as calendar;
use Model\Event as Event;
use Model\PlaceEvent as PlaceEvent;
use Model\Artist as Artist;
use Model\Category as Category;

class Controllercalendar
{
    private $calendarDao;
    private $eventDao;
    private $placeEventDao;
    private $artistDao;
    private $categoryDao;

    public function __construct()
    {
        //$this->calendarDao= new DaoCalendarList();
        //$this->eventDao= new DaoEventList();
        //$this->placeEventDao= new DaoPlaceEventList();
        //$this->artistDao= new daoArtistList();
        
        $this->calendarDao= new DaoCalendarPDO();
        $this->eventDao= new DaoEventPDO();
        $this->placeEventDao= new DaoPlaceEventPDO();
        $this->artistDao= new daoArtistPDO();
        $this->categoryDao= new daoCategoryPDO();
    }

    public function ShowAddCalendarView($message=" ")
    {     
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventList= $this->eventDao->GetAll();
                $placeEventList= $this->placeEventDao->GetAll();
                $artistList= $this->artistDao->GetAll();

                $eventcheck=$this->eventDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();
                $artistcheck = $this->artistDao->GetAll();
                $placecheck = $this->placeEventDao->GetAll();

                if(count($eventcheck)>=1 && (count($categorycheck)>=1) && (count($artistcheck)>=1) && (count($placecheck)>=1)){
                    require_once(VIEWS_PATH . "viewAddcalendar.php");
                }else if(count($categorycheck) <= 0 ){ 
                    $message = 'No se encontraron categorias, por favor ingreselos antes de cargar un evento';
                    require_once(VIEWS_PATH . "viewAddCategory.php");
                }else if((count($eventcheck)<=0)){
                    $message = 'No se encontraron eventos, por favor ingreselas antes de cargar un calendario';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH . "viewAddEvent.php");
                }
                else if(count($artistcheck)<=0){
                    $message = 'No se encontraron artistas, por favor ingreselos antes de cargar un calendario';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH . "viewAddArtist.php");
                }else if(count($placecheck)<=0){
                    $message = 'No se encontraron lugares, por favor ingreselos antes de cargar un calendario';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH . "viewAddPlaceEvent.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewAddcalendar.php");
                }
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
    
    public function ShowListCalendarView($message=" ")
    { 
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $calendarList= $this->calendarDao->GetAll();
                $calendarycheck = $this->calendarDao->GetAll();

                if(count($calendarycheck) <= 0)
                {
                    $message = 'No se encontraron encontraron calendarios para listar... por favor ingrese calendarios !';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    $this->ShowAddCalendarView();
                }
                else
                {
                    require_once(VIEWS_PATH . "viewListcalendar.php");
                }
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
    
    public function ShowModifyCalendarView(calendar $oCalendar, $message= " ")
    {   
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventList= $this->eventDao->GetAll();
                $placeEventList= $this->placeEventDao->GetAll();
                $artistList= $this->artistDao->GetAll();

                $calendarycheck = $this->calendarDao->GetAll();

                if(count($calendarycheck) <= 0)
                {
                    $message = 'No se encontraron encontraron calendarios para modificar... por favor ingrese calendarios !';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCalendar.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifycalendar.php");
                }
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
    
    public function ShowModifyCalendarListView($message=" ")
    { 
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $calendarList= $this->calendarDao->GetAll();
                $calendarycheck = $this->calendarDao->GetAll();

                if(count($calendarycheck) <= 0)
                {
                    $message = 'No se encontraron encontraron calendarios para eliminar... por favor ingrese calendarios !';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    $this->ShowAddCalendarView();
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifycalendarList.php");
                }
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

    public function Add($date, $eventId= null, $placeEventId= null, $selectedArtistArray= null)
    //$categoryId= null para que no de error en el call_user_func antes de entrar al add, si es que no hay 
    //ningun category cargado  
    {
        try 
        {
            $message= "";
            $contAnt= 0;
            $contPost= 0;
            
            if((isset($date))&&(isset($eventId))&&(isset($placeEventId)))
            {
                if((!empty($date))&&(!empty($eventId))&&(!empty($placeEventId)))
                {   
                    if(($this->eventDao->GetByEventId($eventId) != null) && ($this->placeEventDao->GetByPlaceEventId($placeEventId) != null)) 
                        //busca en el DAOevent si existe, si da null, no lo encontro
                        //el combo box junto con los if de arriba hacen que este chequeo e este caso particular
                        //no sea necesario porque nunca llega a esta linea de codigo si el tipo de cerveza no esta
                        //bien seleccionado o no hay cargados. pero esta puesto a modo de ejemplo
                    {
                        $calendar= new Calendar();
                        $calendar->setDate($date);
                        $eventAux= $this->eventDao->GetByeventId($eventId);
                        if(isset($eventAux))
                        {
                            $calendar->setEvent($eventAux);
                        }
                        $placeEventAux= $this->placeEventDao->GetByplaceEventId($placeEventId);
                        if(isset($placeEventAux))
                        {
                            $calendar->setPlaceEvent($placeEventAux);
                        }
                        $artistArray= array();
                        
                        if(isset($selectedArtistArray))
                        {
                            foreach($selectedArtistArray as $artistId)
                            {
                                $artist= $this->artistDao->GetByArtistId($artistId);
                               
                                if(isset($artist))
                                {
                                    array_push($artistArray, $artist);
                                }
                            }
                        }
                        
                        $calendar->setArtistList($artistArray);
                        
                        $contAnt= count($this->calendarDao->GetAll());
                        
                        $this->calendarDao->AddCalendar($calendar);
                        
                        $contPost= count($this->calendarDao->GetAll());

                        if($contAnt < $contPost)
                        {
                            $message = 'agregado correctamente';
                            $this->ShowAddCalendarView($message);
                        }
                        else
                        {
                            $message= "error de carga!!";
                            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                            $this->ShowAddCalendarView($message);
                        }
                    }
                    else
                    {
                        $message= "tipo de dato incorrecto";
                        echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                        $this->ShowAddCalendarView($message);
                    }  
                }
                else
                {
                    $message= "valores incorrectos";
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    $this->ShowAddCalendarView($message);
                }  
            }
            else
            {
                $message= "valores incorrectos";
                echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                $this->ShowAddCalendarView($message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowAddCalendarView($message);
        }
    }

    public function Delete($calendarId)
    {
        try
        {
            $message="";
            $contAnt= 0;
            $contPost= 0;

            if((isset($calendarId)) && (!empty($calendarId)))
            {
                $contAnt= count($this->calendarDao->GetAll());
                
                $this->calendarDao->DeleteCalendar($calendarId);

                $contPost= count($this->calendarDao->GetAll());
                
                if($contAnt > $contPost)
                {
                    $message= "eliminado correctamente!!";
                }
                else
                {
                    $message= "error eliminado!!";
                }
            }
            else
            {
                $message= "parametros incorrectos, no se elimino el registro";
            }
            //$this->ShowListCalendarView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddcalendar.php");
        }
    }

    public function modifyList($id)
    {
        try
        {
            $oCalendar= $this->calendarDao->GetByCalendarId($id);
            
            if(isset($oCalendar))
            {
                $message="";
                $this->ShowModifyCalendarView($oCalendar, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddcalendar.php");
        }
    }

    public function Modify($id, $date, $eventId, $placeEventId, $selectedArtistArray)
    {
        try
        {
            if((isset($id))&&(isset($date))&&(isset($eventId))&&(isset($placeEventId)))
            {
                if((!empty($id))&&(!empty($date))&&(!empty($eventId))&&(!empty($placeEventId)))
                {
                    $calendarNew= new Calendar();
                    $calendarNew->setId($id);
                    $calendarNew->setDate($date);
                    $eventAux= $this->eventDao->GetByeventId($eventId);
                    if(isset($eventAux))
                    {
                        $calendarNew->setEvent($eventAux);
                    }
                    $placeEventAux= $this->placeEventDao->GetByplaceEventId($placeEventId);
                    if(isset($placeEventAux))
                    {
                        $calendarNew->setPlaceEvent($placeEventAux);
                    }
                    $artistArray= array();
                    foreach($selectedArtistArray as $artistId)
                    {
                        $artist= $this->artistDao->GetByArtistId($artistId);
                    
                        if(isset($artist))
                        {
                            array_push($artistArray, $artist);
                        }
                    }
                    $calendarNew->setArtistList($artistArray);

                    $this->calendarDao->ModifyCalendar($id, $calendarNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyCalendarListView($message);
                }
                else
                {
                    $oCalendar= $this->calendarDao->GetByCalendarId($id);
            
                    if(isset($oCalendar))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyCalendarView($oCalendar, $message);
                    }
                }
            }
            else
            {
                $ocalendar= $this->calendarDao->GetBycalendarId($id);
            
                if(isset($ocalendar))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifycalendarView($ocalendar, $message);
                }
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddcalendar.php");
        }
    }
}

?>