<?php
namespace Dao;

use Model\Purchase as Purchase;
use Model\PurchaseRow as PurchaseRow;

interface IDaoBasket
{
    function GetAll();
    function AddPurchase(Purchase $purchase);
    function AddPurchaseRow(PurchaseRow $purchaseRow);
    function GetByPurchaseRowId($purchaseRowId);
    function DeletePurchase();
    function DeletePurchaseRow($purchaseRowId);
    function ModifyPurchaseRow($id, PurchaseRow $purchaseRowNew);
}

?>