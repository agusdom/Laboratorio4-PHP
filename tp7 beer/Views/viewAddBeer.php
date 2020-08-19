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
<div class="container">
    <form action="<?php echo FRONT_ROOT; ?>Beer/Add" method="post">
        <Table>
            <tr>
                <td colspan="2">AGREGAR CERVEZA</td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="name" id=""></td>
            </tr>
            <tr>
                <td>Densidad:</td>
                <td><input type="text" name="density" id=""></td>
            </tr>
            <tr>
                <td>Precio:</td>
                <td><input type="text" name="price" id=""></td>
            </tr>
            <tr>
                <td>Origen:</td>
                <td><input type="text" name="origin" id=""></td>
            </tr>
            <tr>
                <td>Tipo de Cerveza:</td>
                <td>
                    <select name="beerTypeId" id="">
                        <?php
                        foreach($this->beerTypeList->GetAll() as $beerType)
                        {
                            ?>
                            <option value="<?php echo $beerType->getId(); ?>"> <?php echo $beerType->getName(); ?></option>
                            <?php
                        }
                        ?>
                        
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Agregar"></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $message; ?></td>
            </tr>
        </Table>
    </form>
</div>
</body>
</html>