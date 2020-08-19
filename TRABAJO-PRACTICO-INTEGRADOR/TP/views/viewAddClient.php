<?php require_once(VIEWS_PATH . "nav.php"); ?>

<hr>
<div>Cargar Cliente</div>
<form  action="<?php echo FRONT_ROOT; ?>client/Add" method="post">
    <table >
        <tr>
            <td colspan="2">CARGAR CLIENTE</td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre" required></td>
        </tr>
        <tr>
            <td>Apellido:</td>
            <td><input type="text" name="lastName" required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="BTNAddClient" value="Cargar Cliente"></td>
        </tr>
    </table>
</form>
   