<?php
namespace Dao;

use Dao\IDaoBasket as IDaoBasket;
use Model\Purchase as Purchase;
use Model\PurchaseRow as PurchaseRow;

class DaoBasketlist implements IDaoBasket
{
    private $purchase;

    public function __construct()
    {
        if(!isset($_SESSION["userBasket"]))
        {
            $_SESSION["userBasket"]= new Purchase();
        }
        $this->purchase= &$_SESSION["userBasket"];
    }

    function GetAll()
    {
        return $this->purchase;
    }

    public function AddPurchase(Purchase $purchase)
    {
        $id= 0;
        if(!isset($_SESSION["basketId"]))
        {
            $id= 1;
            $_SESSION["basketId"]= $id;
        }
        else
        {
            $id= $_SESSION["basketId"];
            $id++;
            $_SESSION["basketId"]= $id;
        }
        
        $purchase->setId($id);

        $this->purchase= $purchase;
    }

    public function AddPurchaseRow(PurchaseRow $purchaseRow)
    {
        $id= 0;
        if(!isset($_SESSION["basketId"]))
        {
            $id= 1;
            $_SESSION["basketId"]= $id;
        }
        else
        {
            $id= $_SESSION["basketId"];
            $id++;
            $_SESSION["basketId"]= $id;
        }
        
        $purchaseRow->setId($id);

        $purchase= $this->purchase;
        
        $purchaseRowArray= $purchase->getPurchaseRowList();
        array_push($purchaseRowArray, $purchaseRow);
        $this->purchase->setPurchaseRowList($purchaseRowArray) ;
    }

    public function GetByPurchaseRowId($purchaseRowId)
    {
        $purchaseRowArray= $this->purchase->getPurchaseRowList();
        $purchaseRow1= null;
        foreach($purchaseRowArray as $purchaseRow)
        {
            if($purchaseRow->getId() == $purchaseRowId)
            {
                $purchaseRow1= $purchaseRow;
                break;
            }
        }

        return $purchaseRow1;
    }

    public function DeletePurchase()
    {
        unset($_SESSION["userBasket"]); 
    }

    public function DeletePurchaseRow($purchaseRowId)
    {
        $purchaseRowArray= $this->purchase->getPurchaseRowList();
        $i=0;
        foreach($purchaseRowArray as $purchaseRow)
        {
            if($purchaseRow->getId() == $purchaseRowId)
            {
                unset($purchaseRowArray[$i]);
                break;
            }
            $i++;
        }
        
        $purchaseRowArray= array_values($purchaseRowArray);        
        $this->purchase->setPurchaseRowList($purchaseRowArray);
    }

    public function ModifyPurchaseRow($id, PurchaseRow $purchaseRowNew)
    {
        $index=0;
        $purchase= $this->purchase;

        foreach($purchase->getPurchaseRowList() as $purchaseRow)
        {
            if($purchaseRow->getId() == $id)
            {
                $purchaseRowArray= $purchase->getPurchaseRowList();
                array_splice($purchaseRowArray, $index, 1, array($purchaseRowNew)); 
                $this->purchase->setPurchaseRowList($purchaseRowArray);
                break;
            }
            $index++;
        }
    }   

}