<?php
namespace Repository;
use Model\Bill as Bill;

class BillRepository implements IActionsRepository
{
    private $BillRepositoryList=array();

    public function Add(Bill $bill)
    {
        array_push($this->BillRepositoryList,$bill);
    }

    public function GetAll()
    {
        return $this->BillRepositoryList;
    }
}
?>