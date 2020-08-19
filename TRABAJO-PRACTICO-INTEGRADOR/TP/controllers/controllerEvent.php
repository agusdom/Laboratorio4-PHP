<?php 
namespace Controllers;

use Dao\DaoEventList as DaoEventList;
use Dao\DaoEventPDO as DaoEventPDO;
use Dao\DaoCategoryList as DaoCategoryList;
use Dao\DaoCategoryPDO as DaoCategoryPDO;
use Dao\DaoCalendarPDO as DaoCalendarPDO;

use Model\Event as Event;
use Model\Category as Category;
use Model\Calendar as Calendar;
use Model\Photo as Photo;


class ControllerEvent
{
    private $eventDao;
    private $categoryDao;
    private $calendarDao;

    public function __construct()
    {
        $this->eventDao= new DaoEventPDO();
        $this->categoryDao= new DaoCategoryPDO();
        $this->calendarDao= new DaoCalendarPDO();
    }
    

    public function ShowAddEventView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            { 
                $categoryList=$this->categoryDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($categorycheck) <= 0 )
                {
                    $message = 'No se encontraron categorias, por favor ingreselas antes de cargar un evento';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewAddEvent.php");
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
    
    public function ShowListEventView($message=" ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categoryList=$this->categoryDao->GetAll();
                $eventList= $this->eventDao->GetAll();
                $eventcheck = $this->eventDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($eventcheck) <= 0 && count($categorycheck) >= 1 )
                {
                    $message = 'No se encontraron encontraron eventos para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddEvent.php");
                }
                else if(count($eventcheck) >= 0 && count($categorycheck) <= 0)
                {
                    $message = 'Debe ingresar categorias antes de cargar evento.';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewListEvent.php");
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
    
    public function ShowModifyEventView(Event $oEvent, $message= " ")
    {     
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categoryList= $this->categoryDao->GetAll();
                $eventcheck = $this->eventDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($eventcheck) <= 0 && count($categorycheck) >= 1 )
                {
                    $message = 'No se encontraron encontraron eventos para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddEvent.php");
                }
                else if(count($eventcheck) >= 0 && count($categorycheck) <= 0)
                {
                    $message = 'Debe ingresar categorias antes de cargar evento.';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyEvent.php");
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
    
    public function ShowModifyEventListView($message=" ")
    {  
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $eventList= $this->eventDao->GetAll(); 
                $categoryList=$this->categoryDao->GetAll();

                $eventcheck = $this->eventDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($eventcheck) <= 0 && count($categorycheck) >= 1 )
                {
                    $message = 'No se encontraron encontraron eventos para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddEvent.php");
                }
                else if(count($eventcheck) >= 0 && count($categorycheck) <= 0)
                {
                    $message = 'Debe ingresar categorias antes de cargar evento.';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyEventList.php");
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

    public function Add($name, $categoryId= null, $photo=null)
    //$categoryId= null para que no de error en el call_user_func antes de entrar al add, si es que no hay 
    //ningun category cargado  
    {
        try
        {
            $message= "";
            $contAnt= 0;
            $contPost= 0;
            $photo= $_FILES['photo'];

            $eventCheck=$this->eventDao->GetByeventName($name);
            if($eventCheck== null)
                {
                    if((isset($name))&&(isset($categoryId))&&(isset($photo)))
                    {
                        if((!empty($name))&&(!empty($categoryId))&&(!empty($photo)))
                        {   
                            if($this->categoryDao->GetByCategoryId($categoryId) != null) 
                            //busca en el DAOCategory si existe devuelve el objeto, si da null, no lo encontro
                            //el combo box junto con los if de arriba hacen que este chequeo e este caso particular
                            //no sea necesario porque nunca llega a esta linea de codigo id no esta
                            //bien seleccionado o no hay cargados. pero esta puesto a modo de ejemplo
                            {
                                $event= new Event();
                                $event->setName($name);
                                $categoryAux= $this->categoryDao->GetByCategoryId($categoryId);
                                if(isset($categoryAux))
                                {
                                    $event->setCategory($categoryAux);
                                }
                                $screen = new Photo();
                                $screen->uploadPhoto($photo,"events");
                                
                                $event->setPhoto($screen);
                    
                                
                                $contAnt= count($this->eventDao->GetAll());
                                
                                $this->eventDao->AddEvent($event);
                                
                                $contPost= count($this->eventDao->GetAll());

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
                                $message= "tipo de cerveza incorrecto";
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
                }else
                    $message= "el evento ingresado ya se encuentra en la base de datos";
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
        $this->ShowAddEventView($message);
    }

    public function Delete($eventId)
    {
        try
        {
            $message="";
            $contAnt= 0;
            $contPost= 0;
            $exist= false;
            $oCalendar= new Calendar();

            if((isset($eventId)) && (!empty($eventId)))
            {
                foreach($this->calendarDao->GetAll() as $calendar)
                { //verifica si un evento que intento eliminar esta asociado en un calendario
                    $oEvent= $calendar->getEvent();
                    if($oEvent->getId() == $eventId)
                    {
                        $exist= true;
                        $oCalendar= $calendar;     
                    }
                }

                if(!$exist)
                {
                    $contAnt= count($this->eventDao->GetAll());
                
                    $this->eventDao->DeleteEvent($eventId);

                    $contPost= count($this->eventDao->GetAll());
                    
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
                    $message= "error, el evento que intenta eliminar ha sido asociado a al menos un calendario, el ultimo es el calendario de id: ". $oCalendar->getId();
                }   
            }
            else
            {
                $message= "parametros incorrectos, no se elimino el registro";
            }
            $this->ShowListEventView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }

    public function modifyList($id)
    {
        try
        {
            $oEvent= $this->eventDao->GetByEventId($id);
            
            if(isset($oEvent))
            {
                $message="";
                $this->ShowModifyEventView($oEvent, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }


    public function Modify($id, $name, $categoryId, $photo=null)
    {//$categoryName no lo uso pero lo tengo que poner, ya que el form me trae los input por orden
        //y si no lo pongo me confunde el $categoryId con el $categoryName 
        try
        {
            if((isset($name))&&(isset($categoryId)))
            {
                if((!empty($name))&&(!empty($categoryId)))
                {
                    $photo= ($_FILES['photo']['name'] != "") ? $_FILES['photo'] : null;

                    $eventNew= new Event();
                    $eventNew->setId($id);  
                    $eventNew->setName($name);

                    if($photo == null)
                    {//esto me agrega la foto que tenia si decido no modificarla en e modify
                        $oEvent1= $this->eventDao->GetByEventId($id);
                        $photo= $oEvent1->getPhoto();
                        $eventNew->setPhoto($photo);
                    }
                    else
                    {
                        $screen= new Photo();
                        $screen->uploadPhoto($photo, 'events');
                        $eventNew->setPhoto($screen);
                    }
                    
                    $oCategory= $this->categoryDao->GetByCategoryId($categoryId);
                
                    if((isset($oCategory)) && (!empty($oCategory)))
                    {
                        $eventNew->setCategory($oCategory);
                    }

                    $this->eventDao->ModifyEvent($id, $eventNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyEventListView($message);
                }
                else
                {
                    $oEvent= $this->eventDao->GetByEventId($id);
            
                    if(isset($oEvent))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyEventView($oEvent, $message);
                    }
                }
            }
            else
            {
                $oEvent= $this->eventDao->GetByEventId($id);
            
                if(isset($oEvent))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyEventView($oEvent, $message);
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