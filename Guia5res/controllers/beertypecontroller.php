<?php
    namespace Controllers;

    use DAO\BeerTypeDaoList as BeerTypeDaoList;
    use DAO\BeerDaoList as BeerDaoList;
    // use DAO\BeerTypeDaoPDO as BeerTypeDaoPDO;
    use Models\BeerType as BeerType;
    use Models\Beer as Beer;

    class BeerTypeController
    {
        private $beerTypeDAO;
        private $beerDAO;
        
        public function __construct()
        { 
            $this->beerTypeDAO = new BeerTypeDaoList();
            $this->beerDAO = new BeerDaoList();
            // $this->beerTypeDAO = new BeerTypeDaoPDO();
            // $this->beerDAO = new BeerDaoPDO();
        }

        public function ShowAddView($message = "")
        {
            if(!empty($message))
                { echo '<script type="text/javascript">alert("'.$message.'");</script>'; }
            
            require_once(VIEWS_PATH."add-beertype.php");
        }

        public function ShowListView()
        {
            $beerTypeList = $this->beerTypeDAO->GetAll();
            
            require_once(VIEWS_PATH."beertype-list.php");
        }

        public function Add($beerTypeCode, $name, $description, $recipe)
        {
            $beerType = new BeerType();
            $beerType->setBeerTypeCode($beerTypeCode);
            $beerType->setName($name);
            $beerType->setDescription($description);
            $beerType->setRecipe($recipe);

            if($this->beerTypeDAO->GetByCode($beerType->getBeerTypeCode()) == null)
            {
                $this->beerTypeDAO->Add($beerType);
                $message = "Tipo de Cerveza agregado con éxito";
            }
            else
                $message = "Ya existe el Tipo de Cerveza que intenta ingresar";

            $this->ShowAddView($message);            
        }

        public function Delete($beerTypeCode)
        {
            if($this->beerDAO->GetByTypeCode($beerTypeCode) != null)
            {
                $message = 'No se es posible Eliminar este Tipo de Cerveza ya que esta relacionado con al menos una Cerveza.';
                echo '<script type="text/javascript">alert("'.$message.'");</script>';
            }
            else
            {
                $this->beerTypeDAO->Delete($beerTypeCode);
            }

            $this->ShowListView();
        }
    }
?>