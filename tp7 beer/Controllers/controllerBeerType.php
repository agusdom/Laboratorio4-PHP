<?php 
namespace Controllers;

use Dao\DaoBeerTypeList as DaoBeerTypeList;
use Model\BeerType as BeerType;

class ControllerBeerType
{
    private $beerTypeList;

    public function __construct()
    {
        $this->beerTypeList= new DaoBeerTypeList();
    }

    public function ShowAddBeerTypeView($message= " ")
    {
        require_once(VIEWS_PATH . "viewAddBeerType.php");
    }

    public function ShowListBeerTypeView()
    {
        require_once(VIEWS_PATH . "viewListBeerType.php");
    }

    public function ShowDeleteBeerTypeView($message= " ")
    {
        require_once(VIEWS_PATH . "viewDeleteBeerType.php");
    }

    public function ShowModifyBeerTypeListView($message= " ")
    {
        require_once(VIEWS_PATH . "viewModifyBeerTypeList.php");
    }

    public function ShowModifyBeerTypeView($oBeerType, $message= " ")
    {
        require_once(VIEWS_PATH . "viewModifyBeerType.php");
    }

    public function Add($name, $description, $recipe)
    {
        $message="";
        $id=0;
        
        if((isset($name))&&(isset($description))&&(isset($recipe)))
        {
            if((!empty($name))&&(!empty($description))&&(!empty($recipe)))
            {
                if($this->beerTypeList->GetByBeerTypeName($name) == null)
                {
                   $id=0;
                   
                   $array= $this->beerTypeList->GetAll();

                   if(count($array) == 0)
                   {
                       $id=1;
                   }
                   else
                   {
                       $ObeerType= $array[count($array)-1]; 
                       //asigna a ObeerType el ultimo elemento del arreglo
                       $id= $ObeerType->getId();
                       $id++;
                   }
                    
                    $beerType= new BeerType();

                    $beerType->setId($id);
                    $beerType->setName($name);
                    $beerType->setDescription($description);
                    $beerType->setRecipe($recipe);
    
                    $this->beerTypeList->AddBeerType($beerType);
                    
                    $message= "agregado correctamente!!";
                }
                else 
                {
                    $message= "el nombre del tipo de cerveza ya existe";
                }
            }
        }
        $this->ShowAddBeerTypeView($message);
    }

    public function ModifyList($id)
    {
        $ObeerType= $this->beerTypeList->GetByBeerTypeId($id);

        if(isset($ObeerType))
        {
            $message= "";
            $this->ShowModifyBeerTypeView($ObeerType, $message);
        }
    }

    public function Modify($id, $name, $description, $recipe)
    {
        $message= "";

        if((isset($id))&&(isset($name))&&(isset($description))&&(isset($recipe)))
        {
            if((!empty($id))&&(!empty($name))&&(!empty($description))&&(!empty($recipe)))
            {
                $beerTypeNew= new BeerType();
                $beerTypeNew->setId($id);
                $beerTypeNew->setName($name);
                $beerTypeNew->setDescription($description);
                $beerTypeNew->setRecipe($recipe);

                $this->beerTypeList->ModifyBeerType($id, $beerTypeNew);
                $message= "se han modificado los cambios!!";
                $this->ShowModifyBeerTypeListView($message);
            }
            else
            {
                $oBeerType= $this->beerTypeList->GetByBeerTypeId($id);
                if(isset($oBeerType))
                {
                    $message= "error, algun campo esta vacio";
                    $this->ShowModifyBeerTypeView($oBeerType, $message);
                }
            }
        }
        else
        {
            $oBeerType= $this->beerTypeList->GetByBeerTypeId($id);
            if(isset($oBeerType))
            {
                $message= "error, algun campo no esta seteado";
                $this->ShowModifyBeerTypeView($oBeerType, $message);
            }
        }
    }


    public function Delete($id)
    {
        if((isset($id))&&(!empty($id)))
        {
            $message="";
            $contAnt=0;
            $contPost=0;

            $contAnt= count($this->beerTypeList->GetAll());
            $this->beerTypeList->DeleteBeerType($id);
            $contPost= count($this->beerTypeList->GetAll());

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
            $message= "error, valores incorrectos";
        }

        $this->ShowDeleteBeerTypeView($message);
    }
    
}
?>