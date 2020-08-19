<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>listar tipo cerveza</title>
</head>
<body>
    <hr>
    <div class="container">
    <label for="">LISTADO DE TIPO DE CERVEZA</label>
    <?php
    foreach($this->beerTypeList->GetAll() as $beertype)
    {
        echo "<br>";
        echo "<br>Id: ". $beertype->getId();
        echo "<br>Nombre: ". $beertype->getName();
        echo "<br>Descripcion: ". $beertype->getdescription();
        echo "<br>Receta: ". $beertype->getRecipe();
    }
    
    ?>
    </div>
</body>
</html>