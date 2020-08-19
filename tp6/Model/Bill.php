<?php
namespace Model;

use Model\Product as Product;

class Bill
{
    private $firstName;
    private $lastName;
    private $dni;
    private $email;
    private $dateBirth;
    private $billNumber;
    private $billType;
    private $productList=array();

    public function getFirstName()
    {
        return $this->firstName;
    }
    
    public function setFirstName($firstName)
    {
        $this->firstName=$firstName;
    }
    public function getLastname()
    {
        return $this->lastName;
    }
    public function setLastname($lastName)
    {
        $this->lastName=$lastName;
    }
    
    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni)
    {
        $this->dni=$dni;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email=$email;
    }

    public function getDateBirth()
    {
        return $this->dateBirth;
    }

    public function setDateBirth($dateBirth)
    {
        $this->dateBirth=$dateBirth;
    }

    public function getBillNumber()
    {
        return $this->billNumber;
    }

    public function setBillNumber($billNumber)
    {
        $this->billNumber=$billNumber;
    }

    public function getBillType()
    {
        return $this->billType;
    }

    public function setBillType($billType)
    {
        $this->billType=$billType;
    }

    public function AddProduct(Product $product)
    {
        array_push($this->productList,$product);
    }
    public function getSubTotalCost()
    {
        private $subT=0;
        $subT=$this->getSubTotal();
        return $subT;
    }

    public function getTotalCost()
    {
        private $T=0;
        $T=$this->getTotal();
        return $T;
    }


}
?>