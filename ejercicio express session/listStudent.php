<?php
    require_once("autoload.php");

    use Model\Student as Student;
    use Repository\StudentRepository;
    use Repository\IStudentRepository as IStudentRepository; //esto va?

    session_start();

    $studentArray="";

    if(isset($_SESSION["studentArray"]))
    {
        $studentArray = $_SESSION["studentArray"];
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
            <td colspan="2">Lista Estudiantes</td>
        </tr>
    <?php foreach ($studentArray as $student)
    {
        ?>
         <tr>
            <td>Nombre:</td>
            <td> 
                <?php
                Echo $student->getFirstName();
                ?>
            </td>
        </tr>
        <tr>
            <td>Apelido:</td>
            <td> 
                <?php
                Echo $student->getLastName();
                ?>
            </td>
        </tr>
        <tr>
            <td>Direccion:</td>
            <td>
                <?php
                Echo $student->getAddress();
                ?>
            </td>
        </tr>
        <?php
    } ?>
       
    </table>
</body>
</html>