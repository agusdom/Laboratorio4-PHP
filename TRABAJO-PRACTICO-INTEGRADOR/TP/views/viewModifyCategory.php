<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CATEGORIA A MODIFICAR</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>Category/Modify" method="post">
    <table class="modifyList" style="margin: 10px auto; width:40%">
        <tr>
            <th colspan="2">CATEGORIA</th>
        </tr>
        <tr>
            <td>id:</td>
            <td><input type="text" name="id" value="<?php echo $oCategory->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oCategory->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Decripcion:</td>
            <td><input type="text" name="description" value="<?php echo $oCategory->getDescription(); ?>"></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>

</form>
