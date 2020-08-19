<?php
require_once("autoload.php");

use Model\Student as Student;
use Repository\StudentRepository as StudentRepository;
use Repository\IStudentRepository as IStudentRepository; //esto va?

$message= "";

session_start();

if(isset($_SESSION["studentArray"]))
{
   $list = new StudentRepository(); 
   $list= (isset($_SESSION["studentArray"])) ? $_SESSION["studentArray"] : "sin datos";
   echo "<pre>";
   var_dump($list);
   echo "</pre>";
   $message=  count($list->GetAll()); 
}

if($_POST)
{
    if(isset($_POST["btnAddStudent"])) //si presiono el boton submit addStudent
    {
        echo "<br>" . "entra en post" . "<br>"; 
        $firstName= (isset($_POST["firstName"])) ? $_POST["firstName"] : "error in first Name";
        $lastName= (isset($_POST["lastName"])) ? $_POST["lastName"] : "error in last Name";
        $address= (isset($_POST["address"])) ? $_POST["address"] : "error in address";
    
        $student = new Student();
        $student->setFirstName($firstName);
        $student->setLastName($lastName);
        $student->setAddress($address);
        $studentCol= new StudentRepository();
        if(isset($_SESSION["studentArray"]))
        {
            $studentCol= $_SESSION["studentArray"];
            $studentCol->addStudent($student);
            $_SESSION["studentArray"]= $studentCol;
        }
            
    }
    if(isset($_POST["btnListStudent"])) //si presiono el boton submit listStudent
    {
        header("location: listStudent.php");
    }  

}
elseif($_GET)
{
    header("location: index.php?message-error");
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
                <td colspan="2">Agregar Estudiante:</td>
            </tr>
            <tr>
                <td>First Name:</td>
                <td><input type="text" name="firstName" required></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input type="text" name="lastName" required></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" name="address" required></td>
            </tr>
            <tr>
                <td colspan="2" ><input type="submit" name="btnAddStudent" value="Agregar Estudiante"></td>
            </tr>
            <tr>
                <td colspan="2" ><input type="submit" name="btnListStudent" value="listar Estudiante"></td>
            </tr>
            <tr>
                <td colspan="2"> <?php echo $message; ?></td>
            </tr>
        </table>
    </form>
</body>
</html>