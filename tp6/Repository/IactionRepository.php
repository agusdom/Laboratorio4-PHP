<?php
namespace Repository;

use Model\Bill as Bill;

interface IActionRepository{

    public function Add(Bill $bill);
    public function GetAll();
}
?>