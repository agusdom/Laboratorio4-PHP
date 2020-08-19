<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Beer</title>
</head>
<body>
<hr>
<div class="container">
<label for="">LISTADO CERVEZAS</label>
<br>
    <?php
        foreach($this->beerList->GetAll() as $beer)
        {   
            echo "<br>Id: " . $beer->getId();
            echo "<br>Nombre: " . $beer->getName();
            echo "<br>Densidad: " . $beer->getDensity();
            echo "<br>Precio: " . $beer->getPrice();
            echo "<br>Origen: " . $beer->getOrigin();
            echo "<br>Tipo de Cerveza: " . $beer->getBeerTypeId();
            echo "<br>";
        }
    ?>
</div>
</body>
</html>