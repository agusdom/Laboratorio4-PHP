<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modify beer type</title>
</head>
<body>
<hr>
<div class="container">
<form action="<?php echo FRONT_ROOT; ?>BeerType/Modify" method="post">
    <table>
        <tr>
            <td colspan="2"> MODIFICAR TIPO DE CERVEZA</td>
        </tr>
        <tr>
            <td>id:</td>
            <td><input type="text" name="id" value="<?php echo $oBeerType->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oBeerType->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Decripcion:</td>
            <td><input type="text" name="description" value="<?php echo $oBeerType->getDescription(); ?>"></td>
        </tr>
        <tr>
            <td>Receta:</td>
            <td><input type="text" name="recipe" value="<?php echo $oBeerType->getRecipe(); ?>"></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>
</div>
</form>
</body>
</html>