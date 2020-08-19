<?php
namespace Controllers;

use Model\User as User;
use Model\Purchase as Purchase;
use Model\PurchaseRow as PurchaseRow;
use Model\Event as Event;
use Dao\DaoEventPDO as DaoEventPDO;
use Dao\DaoBasketList as DaoBasketList;
use Dao\DaoEventSeatPDO as DaoEventSeatPDO;

class ControllerBasket
{

    private $basketDao;
    private $eventSeatDao;
    private $eventDao;

    public function __construct()
    {
        $this->basketDao= new DaoBasketList();
        $this->eventSeatDao= new DaoEventSeatPDO();
        $this->eventDao= new DaoEventPDO();
    }

    public function ShowUserHomeView($message= null)
    {
        try
        {
            $eventList= $this->eventDao->GetAll();

            if(isset($_SESSION["userLogged"]))
            {
                require_once(VIEWS_PATH . "viewUserHome.php");
            }
            else
            {
                $this->Index();
            }
        } 
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView($message);
        } 
    }   

    public function ShowEventSeatSeatView($eventSeatArray, $message= null)
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
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView($message);
        } 
    }
    
    
    public function ShowUserBasketListView($message= null)
    {
        try
        {
            if(isset($_SESSION["userLogged"]))
            {
                $basketList= $this->basketDao->GetAll();
                require_once(VIEWS_PATH . "viewUserBasketList.php"); 
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
            $this->ShowUserHomeView($message);
        } 
    }

    public function Add($eventSeatId, $SeatQuantity)
    {
        try
        {
            $message= "";
            $max= 0;
            $band= 0;
            $eventSeat= $this->eventSeatDao->getByEventSeatId($eventSeatId);
          
            if($SeatQuantity < $eventSeat->getRemains()) //para que no se intenten vender mas entradas de as que quedan disponibles
            {
                $purchase= $this->basketDao->getAll();
                
                if(count($purchase->getPurchaseRowList()) == 0)
                {
                    $purchase= new Purchase();
                    
                    $user= $_SESSION["userLogged"];
                    $purchase->setUser($user);
                    
                    $this->basketDao->AddPurchase($purchase);   
                    
                }
                else
                {  
                    foreach($purchase->getPurchaseRowList() as $oPurchaseRow)
                    {
                        $oEventSeat= $oPurchaseRow->getEventSeat();

                        if($oEventSeat->getId() == $eventSeat->getId())
                        {
                            $band=1;
                            $auxSeatQuantity= $oPurchaseRow->getQuantity() + $SeatQuantity; //sumo la cantidad de asientos que habia en el carrito + los que agrego
                            
                            $purchaseRowNew= new PurchaseRow();
                            $purchaseRowNew->setId($oPurchaseRow->getId());
                            $purchaseRowNew->setPrice($oEventSeat->getPrice());
                            $purchaseRowNew->setQuantity($auxSeatQuantity);
                            $purchaseRowNew->setEventSeat($oEventSeat);
                            $this->basketDao->ModifyPurchaseRow($oPurchaseRow->getId(), $purchaseRowNew);
                        }
                    }

                }
               
                if($band == 0)
                {
                    $purchaseRow= new PurchaseRow();
        
                    $purchaseRow->setPrice($eventSeat->getPrice());
                    $purchaseRow->setQuantity($SeatQuantity);
                    $purchaseRow->setEventSeat($eventSeat);
                    $this->basketDao->AddPurchaseRow($purchaseRow);
                }
  
                $message= "Agregado al carrito de compras";                
            }
            else
            {
                $calendar= $eventSeat->getCalendar();
                $eventSeatArray= $this->eventSeatDao->getByCalendarId($calendar->getId());
                $message= "no quedan tantos asientos disponibles!!!";
                $this->ShowEventSeatSeatView($eventSeatArray, $message);
            }
            $this->ShowUserBasketListView();            
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView($message);
        }

    }

    public function DeleteRow($purchaseRowId)
    {
        try
        {
            
            $this->basketDao->DeletePurchaseRow($purchaseRowId);
            
            $this->ShowUserBasketListView();
        }
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView($message);
        }
    }

    public function Delete()
    { 
        try
        {
            //borra todos los elementos del session user basket
            $this->basketDao->DeletePurchase();
        } 
        catch(Exception $ex)
        {
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            $this->ShowUserHomeView($message);
        } 
    }
}

?>

