<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>modify beer type list</title>
</head>
<body>
<hr>
<div class="container">
<label for="">LISTADO DE TIPOS DE CERVEZA A MODIFICAR</label>
<table>
<?php
    foreach($this->beerTypeList->GetAll() as $beerType)
    {
        ?>
        <tr>
            <td>
            <?php
                echo "<br>Id: " . $beerType->getId();
                echo "<br>Nombre: " . $beerType->getName(); 
                echo "<br>Descripcion: " . $beerType->getDescription(); 
                echo "<br>Receta: " . $beerType->getRecipe();
            ?>
            </td>
            <td>
                <a href="<?php echo FRONT_ROOT ?> BeerType/ModifyList/ <?php echo $beerType->getId(); ?>"> modificar <?php echo $beerType->getName(); ?> </a>
            </td>
        </tr>
        <?php        
    }
?>
</table>
</div>
</body>
</html>