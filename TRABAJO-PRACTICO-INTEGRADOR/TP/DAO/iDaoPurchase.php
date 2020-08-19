<?php
namespace Dao;

use Model\Purchase as Purchase;
use Model\PurchaseRow as PurchaseRow;

interface IDaoPurchase
{
    function GetAll();
    function AddPurchase(Purchase $purchase);
    function GetPurchaseRowById($purchaseRowId);
    function GetPurchasRowByCalendar($calendarId);
    function GetPurchaseSumQuantityByCalendar($calendarId);
    function GetTotalByCalendar($calendarId);
    //function GetByPurchaseId($purchaseId);
    //function ModifyPurchase($id, Purchase $purchaseNew);
    //function DeletePurchase($purchaseId);
}

?>