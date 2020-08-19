<?php
    namespace Public_html;
    require_once("../Config/autoload.php");

    use Repository\BillRepository as BillRepository;
    use Model\Bill as Bill; 
    
    $billList= new BillRepository();

    session_start();

    if(!isset($_SESSION["billList"]))
    {
        header("location: main.php?message=error");
    }
    else
    {
        $billList= $_SESSION["billList"];
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
    <table border="1">
        <tr>
            <td colspan="2">LISTADO DE FACTURAS</td>
        </tr>
        <?php
        foreach($billList->GetAll() as $bill)
        {
            ?>
            <tr>
                <td colspan="2">FACTURA <?php echo " ". $bill->getBillNumber();?> </td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><?php echo $bill->getFirstName()?></td>
            </tr>
            <tr>
                <td>Apellido:</td>
                <td><?php echo $bill->getLastName()?></td>
            </tr>
            <tr>
                <td>DNI:</td>
                <td><?php echo $bill->getDni()?></td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><?php echo $bill->getEmail()?></td>
            </tr>
            <tr>
                <td>Fecha Nac:</td>
                <td><?php echo $bill->getDateBirth()?></td>
            </tr>
            <tr>
                <td>Numero Fact:</td>
                <td><?php echo $bill->getBillNumber()?></td>
            </tr>
            <tr>
                <td>Tipo Fact:</td>
                <td><?php echo $bill->getBillType()?></td>
            </tr>
            <tr>
                <td>SUBTOTAL:</td>
                <td><?php echo $bill->SubTotalCost()?></td>
            </tr>
            <tr>
                <td>TOTAL:</td>
                <td><?php echo $bill->TotalCost()?></td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="2"><a href="cargarFactura.php">Ir a cagar factura</a></td>
        </tr>
    </table>
</body>
</html>