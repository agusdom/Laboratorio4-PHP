<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <hr>
    <div class="container">
    <table>
    <label for="">LISTADO DE CERVEZAS A MODIFICAR</label>
    <?php 
    foreach($this->beerList->GetAll() as $beer)
    {
    ?>
        <tr>
            <td>
                <?php
                echo "<br> Id: " . $beer->getId();
                echo "<br> Nombre: " . $beer->getName();
                echo "<br> Densidad: " . $beer->getDensity();
                echo "<br> Precio: " . $beer->getPrice();
                echo "<br> Origen: " . $beer->getOrigin();
                $oAux= $this->beerTypeList->GetByBeerTypeId($beer->getBeerTypeId());
                echo "<br> Typo de cerveza: " . $oAux->getName();
                ?>
            </td>
            <td>
                <a href="<?php echo FRONT_ROOT; ?>Beer/ModifyList/ <?php echo $beer->getId(); ?> "> modificar <?php echo $beer->getName(); ?></a>
            </td>
        </tr>
    <?php
    }
    ?>
    </table>
</div>
</body>
</html>