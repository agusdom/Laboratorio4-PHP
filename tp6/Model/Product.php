<?php
namespace Model;

class Product
{
    private $name;
    private $quantity;
    private $price;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name=$name;
    }
    
    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity=$quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price=$price;
    }

    public function getSubTotal()
    {
        private $subT=0;
        $subT=$this->quantity*$this->price;
        return $subT;
    }

    public function getTotal()
    {
        private $T=0;
        $T=$this->getSubTotal();
        if($this->quantity>5&&$this->quantity<10)
        {
            $T-=$this->subTotal()*0.10;
        }
        elseif($this->quantity>10)
        {
            $T-=$this->subTotal()*0.15;
        }
        return $T;
    }


}
?>