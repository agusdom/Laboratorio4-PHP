<?php
require_once("Config/Autoload.php");

use Model\User as User;

$message="";

if($_POST)
{
$defaultmail="cosme@fulanito.com";
$defaultPassword="cosme1234";

$email=(isset($_POST["email"]))?$_POST["email"]:"error email";
$password=(isset($_POST["password"]))?$_POST["password"]:"error password";

if(($defaultmail==$email)&&($defaultPassword==$password))
{
    $user=new User();
    $user->getEmail($email);
    $user->getPassword($password);
    
    session_start();
$_SESSION["userlogged"]=$user;


header("location:Public_html/Main.php");
}
else
{
$message="Wrong Credencial";
}
}
elseif($_GET)
{
    $message=(isset($_GET["message"]))?$_GET["message"]:"";
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
    <td colspan="2">LOGUIN USER</td>
    </tr>
    <tr>
    <td>Email: <input type="email" name="email" requered></td>
    </tr>
    <tr>
    <td>Password: <input type="password" name="password" requered></td>
    </tr>
    <tr>
    <td colspan="2"><input type="submit" name="lguser" value="LOGUEAR"></td>
    <td colspan="2"><input type="reset" name="resert" value="LIMPIAR"></td>
    </tr>
    </table>
    </form>
</body>
</html>