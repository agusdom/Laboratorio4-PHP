<?php
namespace Controllers;
   
use Model\Artist as Artist;
use Model\Photo as Photo;
use Dao\DaoArtistList as DaoArtistList;
use Dao\DaoArtistPDO as DaoArtistPDO;

class ControllerArtist
{
    private $artistDao;

    public function __construct()
    {
        //$this->artistDao= new DaoArtistList();
        $this->artistDao= new DaoArtistPDO();
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
                require_once(VIEWS_PATH . "viewLogin.php");
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowAddArtistView($message);
        } 
    }
    
    public function ShowListArtistView($message=" ")
    {  
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $artistList= $this->artistDao->GetAll();
                $artistcheck = $this->artistDao->GetAll();

                if(count($artistcheck) <= 0 )
                {
                    $message = 'No se encontraron artistas, cargue nuevamente';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddArtist.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewListArtist.php");
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
            $this->ShowAddArtistView($message);
        }
        
    }
    
    public function ShowModifyArtistView(Artist $oArtist, $message= " ")
    {      
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $artistcheck = $this->artistDao->GetAll();

                if(count($artistcheck) <= 0 )
                {
                    $message = 'No se encontraron artistas, cargue nuevamente';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddArtist.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyArtist.php");
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
            $this->ShowAddArtistView($message);
        }     
    }
    
    public function ShowModifyArtistListView($message=" ")
    {   
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $artistList= $this->artistDao->GetAll();
                $artistcheck = $this->artistDao->GetAll();

                if(count($artistcheck) <= 0 )
                {
                    $message = 'No se encontraron artistas, cargue nuevamente';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddArtist.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyArtistList.php");
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
            $this->ShowAddArtistView($message);
        }  
    }


    public function Add($name, $lastName, $artisticName, $photo= null)
    {
        try
        {
            $message= "";
            $contAnt= 0;
            $contPost= 0; 
            $photo= $_FILES['photo'];

            $artisticNameCheck = $this->artistDao->GetByArtisticName($artisticName);
            if($artisticNameCheck == null ){

            if((isset($name))&&(isset($lastName))&&(isset($artisticName))&&(isset($photo)))
            {
                if((!empty($name))&&(!empty($lastName))&&(!empty($artisticName))&&(!empty($photo)))
                {           
                    $artist= new artist();
                    $artist->setName($name);
                    $artist->setLastName($lastName);
                    $artist->setArtisticName($artisticName);

                    $screen = new Photo();
                    
                    $screen->uploadPhoto($photo,"artists");
                    $artist->setPhoto($screen);

                    $contAnt= count($this->artistDao->GetAll());
                    
                    $this->artistDao->AddArtist($artist);
                    
                    $contPost= count($this->artistDao->GetAll());

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
                    $message= "valores incorrectos";
                }  
            }
            else
            {
                $message= "valores incorrectos";
            }
        }else
            $message="El nombre artistico ya esta en uso";
        }catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowAddArtistView($message);
        }

        $this->ShowAddartistView($message);
    }


    public function Delete($artistId)
    {
        try
        {
            $message="";
            $contAnt=0;
            $contPost=0;
        
            if((isset($artistId)) && (!empty($artistId)))
            {
                $contAnt= count($this->artistDao->GetAll());
                
                $this->artistDao->DeleteArtist($artistId);
                
                $contPost= count($this->artistDao->GetAll());

                if($contPost < $contAnt)
                {
                    $message= "eliminado exitosamente";
                }
                else
                {
                    $message= "error, no se encontro el artista";
                }
            }
            else
            {
                $message= "parametros incorrectos";
            }
            $this->ShowListArtistView($message);
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowListArtistView($message);
        }
    }

    public function modifyList($id)
    {
        try
        {
            $oArtist= $this->artistDao->GetByArtistId($id);
            
            if(isset($oArtist))
            {
                $message="";
                $this->ShowModifyartistView($oArtist, $message);
            }
            else
            {
                $message= "error";
                $this->ShowModifyArtistListView($message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowModifyArtistListView($message);
        }
    }

    public function Modify($id, $name, $lastName, $artisticName, $photo= null)
    {  
        try
        { 
            if((isset($id))&&(isset($name))&&(isset($lastName))&&(isset($artisticName)))
            {
                if((!empty($id))&&(!empty($name))&&(!empty($lastName))&&(!empty($artisticName)))
                {           
                    $photo= ($_FILES['photo']['name']!= '') ? $_FILES['photo'] : null;
                    
                    $artistNew= new artist();
                    $artistNew->setId($id);
                    $artistNew->setName($name);
                    $artistNew->setLastName($lastName);
                    $artistNew->setArtisticName($artisticName);
                    
                    //var_dump($photo);

                    if($photo == null)
                    {//esto me agrega la foto que tenia si decido no modificarla en e modify
                        $oArtist1= $this->artistDao->GetByArtistId($id);
                        $photo= $oArtist1->getPhoto();
                        $artistNew->setPhoto($photo);
                    }
                    else
                    {
                        $screen= new Photo();
                        $screen->uploadPhoto($photo, 'artists');
                        $artistNew->setPhoto($screen);
                    }

                    $this->artistDao->Modifyartist($id, $artistNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyartistListView($message);
                }
                else
                {
                    $oArtist= $this->artistDao->GetByArtistId($id);
            
                    if(isset($oArtist))
                    {
                        $message= "algun parametro esta vacio";
                        $this->ShowModifyartistView($oArtist, $message);
                    }
                }
            }
            else
            {
                $oArtist= $this->artistDao->GetByArtistId($id);
            
                if(isset($oArtist))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyArtistView($oArtist, $message);
                }
            } 
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowModifyArtistListView($message);
        }
    }

}
    

?>
 