<?php
require_once("Autoload.php");

use Model\Student as Student;
use Repository\StudentRepository as StudentRepository;

session_start();
//$StudentArray=array(); 

if(!isset($_SESSION["userloader"]))
{
    header("location: Index.php");
}

if(!isset($_SESSION["StudentArray"]))
{
    $StudentArray = new StudentRepository();
    $_SESSION["StudentArray"]= $StudentArray;
}
else
{
    $StudentArray= $_SESSION["StudentArray"];

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
    <tr>
    <td colspan="2">LISTAR ESTUDIANTES</td>
    </tr>
    <?php
    foreach($StudentArray->GetAll() as $Student)
    {
        ?>

        <tr>
        <td>NOMBRE:</td>
        <td> <?php echo $Student->getFirstname(); ?></td>
        </tr>
        <tr>
        <td>APELLIDO:</td>
        <td> <?php echo $Student->getLastname(); ?></td>
        </tr>
        <tr>
        <td>DIRECCION:</td>
        <td> <?php echo $Student->getAddress(); ?></td>
        </tr>
        <?php
    }
    ?>
    </table>
    </form>
</body>
</html>