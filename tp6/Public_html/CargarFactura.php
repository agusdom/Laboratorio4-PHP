<?php
require_once("../Config/Autoload.php");


use Model\Bill as Bill;
use Repository\BillRepository as BillRepository;

$message="";


session_start();

if($_POST)
{
    $firstName=(isset($_POST["firstName"]))?$_POST["firstName"]:"error firstName";
    $lastName=(isset($_POST["lastName"]))?$_POST["lastName"]:"error lastName";
    $dni=(isset($_POST["dni"]))?$_POST["dni"]:"error dni";
    $email=(isset($_POST["email"]))?$_POST["email"]:"error email";
    $dateBirth=(isset($_POST["dateBirth"]))?$_POST["dateBirth"]:"error dateBirth";
    $billNumber=1;
    $billType=(isset($_POST["billType"]))?$_POST["billType"]:"error billType";

    if(isset($_SESSION["billList"]))
    {
        $billList=new BillRepository();
        $billList=$_SESSION["billList"];
        $billNumber=$billNumber+count($billList->GetAll);
    }

    $bill=new Bill();
    $bill->setFirstName($firstName);
    $bill->setLastname($lastName);
    $bill->setDni($dni);
    $bill->setEmail($email);
    $bill->setDateBirth($dateBirth);
    $bill->setBillNumber($billNumber);
    $bill->setBillType($billType);

    $_SESSION["billList"]=$billList;

    header("location:CabeceraFactura.php");
}
elseif($_GET)
{
    header("location:../Index.php?message=error");
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
    <form action="?" method="post">
    <table border="1">
    <tr>
    <td colspan="2">ADD BILL</td>
    </tr>
   
        <tr>
        <td>FirstName:<input type="text" name="firstName" requered></td>
        </tr>
        <tr>
        <td>LastName:<input type="text" name="lastName" requered></td>
        </tr>
        <tr>
        <td>DNI:<input type="number" name="dni" requered></td>
        </tr>
        <tr>
        <td>Email:<input type="email" name="email" requered></td>
        </tr>
        <tr>
        <td>DateBirth: <input type="date" name="dateBirth" requered></td>
        </tr>
        <tr>
        <td>BillNumber: <input type="number" name="billNumber" requered></td>
        </tr>
        <tr>
        <td>BillType:
       <input type="radio" name="billType" Value="A">Factura A
       <input type="radio" name="billType" Value="B">Factura B 
        </td>
        </tr>
        <tr>
        <td><input type="submit" name="btnCargar" value="Enviar"></td>
        </tr>
    <tr>
    <td colspan="2"><a href="../Index.php">IR AL INDEX</td>
    </tr>
    </table>
    </form>
</body>
</html>