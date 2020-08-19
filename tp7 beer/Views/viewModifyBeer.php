<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>modify beer</title>
</head>
<body>
    <hr>
    <div class="container">
    <form action="<?php echo FRONT_ROOT; ?>Beer/Modify" method="post">
        <table>
            <tr>
                <td colspan="2">MODIFICAR CERVEZA</td>
            </tr>
            <tr>
                <td>Id:</td>
                <td><input type="text" name="id" value="<?php echo $oBeer->getId(); ?>" readonly></td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="name" value="<?php echo $oBeer->getName(); ?>"></td>
            </tr>
            <tr>
                <td>Densidad:</td>
                <td><input type="text" name="density" value="<?php echo $oBeer->getDensity(); ?>"></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><input type="text" name="price" value="<?php echo $oBeer->getPrice(); ?>"></td>
            </tr>
            <tr>
                <td>Origen:</td>
                <td><input type="text" name="origin" value="<?php echo $oBeer->getOrigin(); ?>"></td>
            </tr>
            <tr>
                <td>Tipo de Cerveza:</td>
                <?php $oBeerType =$this->beerTypeList->GetByBeerTypeId($oBeer->getBeerTypeId()); ?>
                <td><input type="text" name="beerTypeName" value="<?php echo $oBeerType->GetName(); ?>"></td>
            <tr>
            </tr>
                <td><input type="hidden" name="beerTypeId" value="<?php echo $oBeer->getBeerTypeId(); ?>" ></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Guardar Cambios"></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $message; ?></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>