<?php
require_once("../Config/Autoload.php");

use Model\Bill as Bill;
use Repository\BillRepository as BillRepository;


$billList=new BillRepository();

session_start();
if(isset($_SESSION["billList"]))
{
$billList=$_SESSION["billList"];
}
else
{
    header("location:Main.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
    <tr>
    <td colspan="2">LIST BILL</td>
    </tr>
    <?php
    foreach($billList->GetAll() as $Bill)
    {
        ?>
        <tr>
        <td>BillNumber:<?php $Bill->getBillNumber()?></td>
        </tr>
        <tr>
        <td>FirstName:<?php $Bill->getFirstName()?></td>
        </tr>
        <tr>
        <td>LastName:<?php $Bill->getLastName()?></td>
        </tr>
        <tr>
        <td>DNI:<?php $Bill->getDni()?></td>
        </tr>
        <tr>
        <td>Email:<?php $Bill->getEmail()?></td>
        </tr>
        <tr>
        <td>DateBirth:<?php $Bill->getDateBirth()?></td>
        </tr>
        <tr>
        <td>BillType:<?php $Bill->getBillType()?></td>
        </tr>
        <?php
    }
    ?>
    </table>
</body>
</html>