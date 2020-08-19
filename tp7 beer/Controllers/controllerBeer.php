<?php 
namespace Controllers;

use Dao\DaoBeerList as DaoBeerList;
use Dao\DaoBeerTypeList as DaoBeerTypeList;

use Model\Beer as Beer;

class ControllerBeer
{
    private $beerList;
    private $beerTypeList;

    public function __construct()
    {
        $this->beerList= new DaoBeerList();
        $this->beerTypeList= new DaoBeerTypeList();
    }

    public function ShowAddBeerView($message=" ")
    {
        require_once(VIEWS_PATH . "viewAddBeer.php");
    }
    
    public function ShowListBeerView()
    {
        require_once(VIEWS_PATH . "viewListBeer.php");
    }
    
    public function ShowDeleteBeerView($message=" ")
    {
        require_once(VIEWS_PATH . "viewDeleteBeer.php");
    }
    
    public function ShowModifyBeerView(Beer $oBeer, $message= " ")
    {
        require_once(VIEWS_PATH . "viewModifyBeer.php");
    }
    
    public function ShowModifyBeerListView($message=" ")
    {
        require_once(VIEWS_PATH . "viewModifyBeerList.php");
    }

    public function Add($name, $density, $price, $origin, $beerTypeId)
    {
        $message= "";

        if((isset($name))&&(isset($density))&&(isset($price))&&(isset($origin))&&(isset($beerTypeId)))
        {
            if((!empty($name))&&(!empty($density))&&(!empty($price))&&(!empty($origin))&&(!empty($beerTypeId)))
            {   
                if($this->beerTypeList->GetByBeerTypeId($beerTypeId) != null) 
                //busca en el DAOBeerType si existe el nombre de tipo de cerveza, si da null, no lo encontro
                //el combo box junto con los if de arriba hacen que este chequeo e este caso particular
                //no sea necesario porque nunca llega a esta linea de codigo si el tipo de cerveza no esta
                //bien seleccionado o no hay cargados. pero esta puesto a modo de ejemplo
                {
                    if($this->beerList->GetByBeerName($name) == null)
                    {
                        //ahora setea el id para que sea siempre distinto y mayor a los anteriores
                        $id=0;
                        $array= $this->beerList->GetAll();
                        
                        if(count($array) == 0)
                        {
                            $id=1;
                        }
                        else
                        {
                            $Obeer= $array[count($array)-1];
                            $id= $Obeer->getId();
                            $id++;
                        }
                        
                        $beer= new Beer();
                        $beer->setId($id);  
                        //$beer->setId((count($this->beerList->GetAll())+1));
                        $beer->setName($name);
                        $beer->setDensity($density);
                        $beer->setPrice($price);
                        $beer->setOrigin($origin);
                        $beer->setBeerTypeId($beerTypeId);
                        $this->beerList->AddBeer($beer);
                        $message= "agregado correctamente";
                    }
                    else
                    {
                        $message= "el nombre de la cerveza ya existe";
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
        $this->ShowAddBeerView($message);
    }

    public function Delete($beerId)
    {
        $message="";

        if((isset($beerId)) && (!empty($beerId)))
        {
            $this->beerList->DeleteBeer($beerId);
            $message= "eliminado correctamente!!";
        }
        else
        {
            $message= "parametros incorrectos, no se elimino el registro";
        }
        $this->ShowDeleteBeerView($message);
    }

    public function modifyList($id)
    {
        $oBeer= $this->beerList->GetByBeerId($id);
        
        if(isset($oBeer))
        {
            $message="";
            $this->ShowModifyBeerView($oBeer, $message);
        }
    }

    public function Modify($id, $name, $density, $price, $origin, $beerTypeName, $beerTypeId)
    {
        if((isset($name))&&(isset($density))&&(isset($price))&&(isset($origin))&&(isset($beerTypeId)))
        {
            if((!empty($name))&&(!empty($density))&&(!empty($price))&&(!empty($origin))&&(!empty($beerTypeId)))
            {
                $beerNew= new Beer();
                $beerNew->setId($id);  
                $beerNew->setName($name);
                $beerNew->setDensity($density);
                $beerNew->setPrice($price);
                $beerNew->setOrigin($origin);
                $beerNew->setbeerTypeId($beerTypeId);

                $this->beerList->ModifyBeer($id, $beerNew);
                $message= "se han modificado los cambios!!";
                $this->ShowModifyBeerListView($message);
            }
            else
            {
                $oBeer= $this->beerList->GetByBeerId($id);
        
                if(isset($oBeer))
                {
                    $message= "algun parametro esta vacio";
                    $this->ShowModifyBeerView($oBeer, $message);
                }
            }
        }
        else
        {
            $oBeer= $this->beerList->GetByBeerId($id);
        
                if(isset($oBeer))
                {
                    $message= "algun parametro no esta seteado";
                    $this->ShowModifyBeerView($oBeer, $message);
                }
        }
       
    }


}

?>