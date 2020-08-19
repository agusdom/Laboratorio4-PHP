<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>delete beer type</title>
</head>
<body>
<hr>
<div class="container">
    <form action="<?php echo FRONT_ROOT; ?>BeerType/Delete" method="post">
        <table>
            <tr>
                <td colspan="2">BORRAR TIPO DE CERVEZA</td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td>
                    <select name="beerTypeName" id="">
                    <?php
                        foreach($this->beerTypeList->Getall() as $beerType)
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
                <td><input type="submit" value="Eliminar"></td>
            </tr>
        </table>
    </form>
    <div><?php echo $message; ?></div>
</div>
</body>
</html>