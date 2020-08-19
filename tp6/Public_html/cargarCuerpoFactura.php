<?php
require_once("../Config/autoload.php");

use Model\Bill as Bill;
use Repository\BillRepository as BillRepository; 
use Model\Product as Product;

$bill= new Bill();
$billList= new BillRepository();
$product= new Product(); //como solamente le agrego un objeto session supuestamente no es necesario
                        // hacerle new de product
session_start();

if(isset($_SESSION["bill"]))
{
    $bill= $_SESSION["bill"];
}
else
{
    header("location: index.php?message=error");
}
   
if($_POST)
{
    if(isset($_POST["BTNLoadProduct"]))
    {
        $name= (isset($_POST["name"])) ? $_POST["name"] : "error post name"; 
        $quantity= (isset($_POST["quantity"])) ? $_POST["quantity"] : "error post quantity"; 
        $price= (isset($_POST["price"])) ? $_POST["price"] : "error post price"; 
    
        $product->setName($name);
        $product->setquantity($quantity);
        $product->setprice($price);
        
        $bill->AddProduct($product);
        $_SESSION["bill"]= $bill;
    }
    elseif(isset($_POST["BTNLoadBill"]))
    {
        if(isset($_SESSION["billList"]))
        {
            $billList= $_SESSION["billList"];
            $billList->Add($bill);   
            $_SESSION["billList"]= $billList;
        }
        else
        {

            $billList->Add($bill);   
            $_SESSION["billList"]= $billList;
        }
        /*
        echo "<pre>";
        var_dump($billList->GetAll());
        echo "</pre>";
        */
        header("location: main.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
<form action="?" method="post">
        <table border="1">
            <tr>
                <td colspan="2">CARGAR PRODUCTOS</td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="name"></td>
            </tr>
            <tr>
                <td>Cantidad:</td>
                <td><input type="text" name="quantity"></td>
            </tr>
            <tr>
                <td>Precio:</td>
                <td><input type="text" name="price"></td>
            </tr>
            <tr>
                <td><input type="submit" name="BTNLoadProduct" value="Guardar Producto"></td>
            </tr>
            <tr>
                <td><input type="submit" name="BTNLoadBill" value="Guardar Factura"></td>
            </tr>
            <tr>
                <td><a href="cargarFactura.php">Ir a: Cargar Nueva Factura</a></td>
            </tr>
            <tr>
                <td><a href="listarFacturacion.php">Ir a: Listar Facturacion</a></td>
            </tr>
            <tr>
                <td><a href="../index.php">Ir al index</a></td>
            </tr>
        </table>
    </form>
<?php //----------FORMULARIO CABECERA FACTURA -------------------------?>

<form action="?" method="post">
        <table border="1">
            <tr>
                <td colspan="10">FACTURA</td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><?php echo $bill->getFirstName() ?></td>
            </tr>
            <tr>
                <td>Apellido:</td>
                <td><?php echo $bill->getLastName() ?></td>
            </tr>
            <tr>
                <td>DNI:</td>
                <td><?php echo $bill->getDni() ?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $bill->getEmail() ?></td>
            </tr>
            <tr>
                <td>fecha de Nacimiento:</td>
                <td><?php echo $bill->getDateBirth() ?></td>
            </tr>
            <tr>
                <td>Numero de Factura:</td>
                <td><?php echo $bill->getBillNumber() ?></td>
            </tr>
            <tr>
                <td>Tipo Factura</td>
                <td>
                    <?php 
                    $billType= $bill->getBillType();
                    strtoupper($billType); 
                    echo $billType ?>
                </td>
            </tr>
            <tr>
                <td colspan="10">PRODUCTOS</td>
            </tr>
            <?php
            foreach($bill->GetAll() as $productAux)
            {
                ?>
                <tr>
                    <td>Nombre:</td>
                    <td><?php echo $productAux->getName(); ?></td>
                    <td>Cantidad:</td>
                    <td><?php echo $productAux->getQuantity(); ?></td>
                    <td>Price:</td>
                    <td><?php echo $productAux->getPrice(); ?></td>
                    <td>Subtotal:</td>
                    <td><?php echo $productAux->GetSubTotal(); ?></td>
                    <td>Total:</td>
                    <td><?php echo $productAux->GetTotal(); ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7">SubTotal:</td>
                <td><?php echo $bill->SubTotalCost() ?></td>
                <td colspan="2"><?php echo " ";?></td>
            </tr>
            <tr>
                <td colspan="9">Total:</td>
                <td><?php echo $bill->TotalCost() ?></td>
            </tr>
        </table>
    </form>

   
    
</body>
</html>

