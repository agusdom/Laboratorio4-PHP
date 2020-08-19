<?php 
namespace Controllers;

use Dao\DaoCategoryList as DaoCategoryList;
use Dao\DaoCategoryPDO as DaoCategoryPDO;
use Dao\DaoEventList as DaoEventList;
use Dao\DaoEventPDO as DaoEventPDO;
use Model\Category as Category;

class ControllerCategory
{
    private $categoryDao;
    private $eventDao;

    public function __construct()
    {
        //$this->categoryDao= new DaoCategoryList();
        //$this->eventDao= new DaoEventList();
        $this->categoryDao= new DaoCategoryPDO();
        $this->eventDao= new DaoEventPDO();

    }

    public function ShowAddCategoryView($message= " ")
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewAddCategory.php"); 
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

    public function ShowListCategoryView($message= " ")
    {      
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categoryList= $this->categoryDao->GetAll();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($categorycheck) <= 0 )
                {
                    $message = 'No se encontraron encontraron categorias para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewListCategory.php");
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

    public function ShowModifyCategoryListView($message= " ")
    {     
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categoryList= $this->categoryDao->Getall();
                $categorycheck = $this->categoryDao->GetAll();

                if(count($categorycheck) <= 0 )
                {
                    $message = 'No se encontraron encontraron categorias para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyCategoryList.php");
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

    public function ShowModifyCategoryView($oCategory, $message= " ")
    {  
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $categorycheck = $this->categoryDao->GetAll();

                if(count($categorycheck) <= 0 )
                {
                    $message = 'No se encontraron encontraron categorias para mostrar';
                    echo '<script type="text/javascript">confirm("'.$message.'");</script>';
                    require_once(VIEWS_PATH."viewAddCategory.php");
                }
                else
                {
                    require_once(VIEWS_PATH . "viewModifyCategory.php");
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

    public function Add($name, $description)
    {
        try
        {
            $message="";
            $contAnt=0;
            $contPost=0;
            
            $categorycheck= $this->categoryDao->GetByCategoryName($name);
            if($categorycheck==null){
                if((isset($name))&&(isset($description)))
                {
                    if((!empty($name))&&(!empty($description)))
                    {
                        $category= new Category();
                        $category->setName($name);
                        $category->setDescription($description);
                        
                        $contAnt= count($this->categoryDao->GetAll());
                        
                        $this->categoryDao->AddCategory($category);
                        
                        $contPost= count($this->categoryDao->GetAll());
                        if($contAnt < $contPost)
                        {
                            $message= "agregado correctamente!!";
                        }
                        else
                        {
                            $message= "error de carga!!";
                        }
                    }
                }
            }else
                $message="La categoria ingresada ya se encuentra en la base de datos";
        }    
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
        $this->ShowAddCategoryView($message);
    }


    public function ModifyList($id)
    {
        try
        {
            $oCategory= $this->categoryDao->GetByCategoryId($id);

            if(isset($oCategory))
            {
                $message= "";
                $this->ShowModifyCategoryView($oCategory, $message);
            }
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewAddArtist.php");
        }
    }

    public function Modify($id, $name, $description)
    {
        try
        {
            $message= "";

            if((isset($id))&&(isset($name))&&(isset($description)))
            {
                if((!empty($id))&&(!empty($name))&&(!empty($description)))
                {
                    $categoryNew= new Category();
                    $categoryNew->setId($id);
                    $categoryNew->setName($name);
                    $categoryNew->setDescription($description);

                    $this->categoryDao->ModifyCategory($id, $categoryNew);
                    $message= "se han modificado los cambios!!";
                    $this->ShowModifyCategoryListView($message);
                }
                else
                {
                    $oCategory= $this->categoryDao->GetByCategoryId($id);
                    if(isset($oCategory))
                    {
                        $message= "error, algun campo esta vacio";
                        $this->ShowModifyCategoryView($oCategory, $message);
                    }
                }
            }
            else
            {
                $oCategory= $this->categoryDao->GetByCategoryId($id);
                if(isset($oCategory))
                {
                    $message= "error, algun campo no esta seteado";
                    $this->ShowModifyCategoryView($oCategory, $message);
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

                foreach($this->eventDao->GetAll() as $event)
                {
                    if($event->getCategory()->getId() == $id)
                    {
                        $delete= false;
                        break;
                    }
                }
                if($delete)
                {
                    $contAnt= count($this->categoryDao->GetAll());
                    $this->categoryDao->DeleteCategory($id);
                    $contPost= count($this->categoryDao->GetAll());
        
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
                    $message= "la categoria que intenta eliminar tiene eventos asociados";
                }
            }
            else
            {
                $message= "error, valores incorrectos";
            }

            $this->ShowListCategoryView($message);
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