<?php require_once(VIEWS_PATH . "nav.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eliminar cerveza</title>
</head>
<body>
<hr>
<div class="container">
<div><label for="">BORRAR CERVEZA</label></div>
    <form action="<?php echo FRONT_ROOT; ?> Beer/Delete" method="post">
        <table>
            <tr>
                <td>Nombre: </td>
                <td>
                    <select name="beerName" id="">
                    <?php
                    foreach($this->beerList->GetAll() as $beer)
                    {
                        ?>
                        <option value="<?php echo $beer->getId(); ?>"> <?php echo $beer->getName(); ?> </option>
                    <?php
                    }
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="eliminar"></td>
            </tr>
            
            
        </table>
    </form>
    <div><?php echo $message; ?></div>
</div>
</body>
</html>