<?php
require_once("Autoload.php");


use Model\ User as User;

$message="";
$error="";

session_start();
if(!isset($_SESSION["userloader"]))
{
    
    header("location: index.php");
}
else
{
    $user= $_SESSION["userloader"];
    $mail=$user->getEmail();

    echo "<br>Bienvenido:" . $mail;
}

if($_POST)
{

    if(isset($_POST["btnCargar"]))
    {
        header("location: Cargar.php");
    }
    if(isset($_POST["btnListar"]))
    {
        header("location: Listar.php");
    }
}
elseif($_GET)
{
    header("location: Index.php ? message=error");
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
    <td colspan="2">USER MENU</td>
    </tr>
    <tr>
    <td colspan="2"> <input type="submit" name="btnCargar" value="CARGAR"></td>
    <td colspan="2"> <input type="submit" name="btnListar" value="LISTAR"></td>
    </tr>
    </table>
    </form>
</body>
</html>