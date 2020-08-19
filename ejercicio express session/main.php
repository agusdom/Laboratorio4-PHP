<?php
    require_once("autoload.php");

    use Model\User as User;

    $message="";
    $error="";
session_destroy();
    session_start();

    if($_SESSION)
    {
        $user= $_SESSION["userLogged"];
        
        $Email= $user->getEmail();
        $message= "Bienvenido: " . $Email;
    }
    elseif($_GET)
    {
        header("location:index.php?message-error");
    }
    else
    {
        $error= "error";
    }
    

    if($_POST) //dependiendo de que boton submit elija me dirije a uno u a otro archivo
    {
        if(isset($_POST["addStudent"]))
        {
            header("location: addStudent.php");
        }
        if(isset($_POST["listStudent"]))
        {
            header("location: listStudent.php");
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
    <form action="?"method="post">
        <table border="1">
            <tr>
                <td colspan="2"><?php echo $message; ?> </td>
            </tr>
            <tr>
                <td><input type="submit" name="addStudent" value="Add Student"></td>
                <td><input type="submit" name="listStudent" value="List Student"></td>
            </tr>
            <tr>
            <td colspan="2"> <?php echo $error;?> </td>
            </tr>
        </table>
    </form>
</body>
</html>