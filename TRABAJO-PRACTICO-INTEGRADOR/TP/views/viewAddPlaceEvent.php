<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CARGAR LUGAR DE EVENTO</label>
</div>

<form  action="<?php echo FRONT_ROOT; ?>PlaceEvent/Add" method="post">
    <table class="modifyList" style="margin: 10px auto; width:40%">
        <tr>
            <th colspan="2">LUGAR DE EVENTO</th>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre" required></td>
        </tr>
        <tr>
            <td>Capacidad:</td>
            <td><input type="number" name="capacity" min=1 required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="BTNAddPlaceEvent" value="Cargar"></td>
            <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>PlaceEvent/ShowListPlaceEventView "> Ver Listado Lugares</a></td></tr>
        </tr>
        </tr>
        <td colspan="2"><?php if(isset($message)) echo $message; ?></td>
    </tr>
    </table>
</form>
