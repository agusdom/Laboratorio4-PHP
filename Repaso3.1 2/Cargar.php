<?php
require_once("Autoload.php");

use Model\Student as Student;
use Repository\StudentRepository as StudentRepository ;

$message="";

session_start();

if(!isset($_SESSION["userloader"]))
{
    header("location: index.php");
}

if(!isset($_SESSION["StudentArray"]))
{
    $list=new StudentRepository();
    $_SESSION["StudentArray"]=$list;
    $message=count($list->GetAll());
}
else
{
    $list=$_SESSION["StudentArray"];
}

if($_POST)
{
    
    if(isset($_POST["btnCargar"]))
    {
      $firstname=(isset($_POST["firstname"])) ?  $_POST["firstname"] : "error en el firstname";
      $lastname=(isset($_POST["lastname"])) ?  $_POST["lastname"] : "error en el lastname";
      $address=(isset($_POST["address"])) ?  $_POST["address"] : "error en el address";

      $student=new Student();
      $student->setFirstname($firstname);
      $student->setLastname($lastname);
      $student->setAddress($address);
      $list->Add($student);
      $_SESSION["StudetArray"]= $list;

    }
    elseif(isset($_POST["btnListar"]))
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
    <td colspan="2">CARGAR STUDENTS </td>
    </tr>
    <tr>
    <td> Nombre: <input type="text" name="firstname" requered></td>
    </tr>
    <tr>
    <td> Apellido: <input type="text" name="lastname" requered></td>
    </tr>
    <tr>
    <td> Direccion: <input type="text" name="address" requered></td>
    </tr>
    <tr>
    <td colspan="2"> <input type="submit" name="btnCargar" value="CARGAR"></td>
    <td colspan="2"> <input type="submit" name="btnListar" value="VISTA"></td>
    </tr>
    </table>
    </form>
</body>
</html>