<?php
require_once("../Config/Autoload.php");

use Model\User as User;

$message="";
$error="";

if(isset($_SESSION))
{
    $mail=$user->getEmail();
    echo "Bienventido".$email;
}
elseif($_GET)
{
    header("location:Index.php?message-error");
}
else
{
    $error="error";
}

if($_POST)
{
    if(isset($_POST["btnCargar"]))
    {
        header("location:CabeceraFactura.php");
    }
    elseif(isset($_POST["btnListar"]))
    {
        header("location:ListarFactura.php");
    }
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
    <td colspan="2">MENU USER</td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="btnCargar" value="CARGAR"></td>
    <td colspan="2"><input type="submit" name="btnListar" value="LISTAR"></td>
    </tr>
    </table>
    </form>
</body>
</html>