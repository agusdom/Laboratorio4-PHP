<?php
namespace Model;

use Model\User as User;
use Model\PurchaseRow as PurchaseRow;

class Purchase
{
    private $id;
    private $date;
    private $user;
    private $purchaseRowList= array();

    public function setId($id)
    {
        $this->id= $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDate($date)
    {
        $this->date= $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setUser(User $user)
    {
        $this->user= $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setPurchaseRowList($purchaseRowList)
    {
        $this->purchaseRowList= $purchaseRowList;
    }

    public function getPurchaseRowList()
    {
        return $this->purchaseRowList;
    }
}

?>