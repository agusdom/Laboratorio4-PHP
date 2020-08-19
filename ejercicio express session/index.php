<?php
require_once("autoload.php");

use Model\User as User;

$message= "";

if($_POST)
{
    $defaultEmail= "cosme@fulanito.com";
    $defaultPassword= "cosme1234"; 

    $email= (isset($_POST["email"])) ? $_POST["email"] : "error email";
    $password = (isset($_POST["password"])) ? $_POST["password"] : "error password";

    if(($defaultEmail == $email)&&($defaultPassword == $password))
    {
        $user= new User();
        $user->setEmail($email);
        $user->setPassword($password);
        echo $user->getEmail(). "<br>";
        echo $user->getPassword(). "<br>";
        session_start();

        $_SESSION["userLogged"]= $user;

        header("location: main.php");
    }
    else
    {
        $message = "Wrong Credentials";
    }
    

}
elseif($_GET)
{
    $message= (isset($_GET["message"])) ? $_GET["message"] : ""; 
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
                <td  colspan="2" > LOGIN </td>
            </tr>
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" require></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" require></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" name="BtnLogin" value="Login"></td>
            </tr>
            <tr>
                <td colspan="2"> mensage <?php echo $message; ?></td>
            </tr>
        </table>
    </form>
</body>
</html>