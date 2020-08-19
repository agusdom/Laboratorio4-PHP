<?php require_once(VIEWS_PATH . "nav.php"); ?>

<hr>
<div class="container">
<form action="<?php echo FRONT_ROOT; ?>client/Modify" method="post">
    <table>
        <tr>
            <td colspan="2"> MODIFICAR CLIENTE</td>
        </tr>
        <tr>
            <td>dni:</td>
            <td><input type="number" name="dni" value="<?php echo $oArtist->getDni(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oArtist->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Apellido:</td>
            <td><input type="text" name="lastName" value="<?php echo $oArtist->getLastName(); ?>"></td>
        </tr>
        
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>
</div>
</form>
