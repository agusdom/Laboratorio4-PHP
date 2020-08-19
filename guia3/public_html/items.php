<?php  
class items{
private $detalle;
private $cantidad;
private $precio;

public function __construct($detalle, $cantidad, $precio){
            $this -> setDetalle($detalle);
            $this -> setCantidad($cantidad);
            $this -> setPrecio($precio);
        }

        public function getDetalle(){
            return $this -> detalle;
        }

        public function getCantidad(){
            return $this -> cantidad;
        }

        public function getPrecio(){
            return $this -> precio;
        }

        public function setDetalle($detalle){
            $this -> detalle = $detalle;
        }

        public function setCantidad($cantidad){
            $this -> cantidad = $cantidad;
        }

        public function setPrecio($precio){
            $this -> precio = $precio;
        }

public fuction CalcularPrecioTotal()
{
$total=$this->precio * this->cantidad;

if($this->cantida>=10)
{
$total -= $this->total *0.10;
}
else if($this->cantida>=5)
{
$total -= $this->total *0.5;
}
return $total;
}
}
?>

