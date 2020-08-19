<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">LISTADO DE LUGARES DE EVENTO A MODIFICAR</label>
</div>

<form action="<?php echo FRONT_ROOT; ?>PlaceEvent/Modify" method="post">
    <table class="modifyList" style="margin: 10px auto; width:35%">
        <tr>
            <th colspan="2">EVENTO</th>
        </tr>
        <tr>
            <td>id:</td>
            <td><input type="number" name="id" value="<?php echo $oPlaceEvent->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oPlaceEvent->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Capacidad:</td>
            <td><input type="text" name="capacity" value="<?php echo $oPlaceEvent->getCapacity(); ?>"></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>
</form>
