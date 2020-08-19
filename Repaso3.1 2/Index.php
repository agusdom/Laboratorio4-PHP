<?php
require_once("Autoload.php");

use Model\User as User;

$message="";

if($_POST)
{
$defaultemail="cosme@fulanito.com";
$defaultpassword="1234";

$email=(isset($_POST["email"])) ? $_POST["email"] : "error en el email";
$password=(isset($_POST["password"])) ? $_POST["password"] : "error en el password";

if(($defaultemail == $email) && ($defaultpassword == $password))
{

    $user=new User();
    $user->setEmail($email);
    $user->setPassword($password);
    session_start();

    $_SESSION["userloader"]=$user;

    header("location: Main.php");
}
else
{
    echo "Wrong Credencial";
}
}
elseif($_GET)
{
    $message=(isset($_GET["message"])) ? $_GET["message"] : "";
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
    <table border="2">
    <tr>
    <td colspan="2">LOGUIN USER</td>
    </tr>
    <tr>
    <td> Nombre: <input type="text" name="name" requered></td>
    </tr>
    <tr>
    <td> Email: <input type="email" name="email" requered></td>
    </tr>
    <tr>
    <td> Password: <input type="password" name="password" requered></td>
    </tr>
    <tr>
    <td colspan="2"> <input type="submit" name="btnLogueo" value="LOGUEO"></td>
    <td colspan="2"> <input type="reset" name="btnReseteo" value="RESETEO"></td>
    </tr>
    </table>
    </form>
</body>
</html>