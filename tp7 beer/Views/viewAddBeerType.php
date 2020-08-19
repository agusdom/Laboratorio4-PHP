<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>add beer type</title>
</head>
<body>
<div class="container">
    <form action="<?php echo FRONT_ROOT; ?>BeerType/Add" method="post">
        <table>
            <tr>
                <td colspan="2">AGREGAR TIPO CERVEZA</td>            
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="name" id=""></td>
            </tr>
            <tr>
                <td>Descripcion:</td>
                <td><input type="text" name="description" id=""></td>
            </tr>
            <tr>
                <td>Receta:</td>
                <td><input type="text" name="recipe" id=""></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Agregar"></td>
            </tr>    
        </table>
    </form>
        <div><?php echo $message; ?></div>
</div>
</body>
</html>