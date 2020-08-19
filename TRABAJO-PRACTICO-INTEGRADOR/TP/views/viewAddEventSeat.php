<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CARGAR ASIENTOS AL CALENDARIO</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>EventSeat/Add" method="post">
    <table class="modifyList" style="margin: 10px auto; width:40%">
        <tr>
            <th colspan="2">CALENDARIO</th>
        </tr>
        <tr>
            <td>Calendario:</td>
            <td>
                <select id="select1" name="eventSeat" id="">
                    <?php
                    foreach($calendarList as $calendar)
                    {
                        $Event= $calendar->getEvent();
                        $placeEvent= $calendar->getPlaceEvent();
                        ?>
                        <option value="<?php echo $calendar->getId(); ?>"> <?php echo "fecha: ".$calendar->getDate(). " | Evento: ".$Event->getName(). " | Lugar: ".$placeEvent->getName(); ?> </option>
                    <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tipo de Asiento:</td>
            <td>
                <select id="select1" name="seatType" id="">
                    <?php
                    foreach($setTypeList as $seatType)
                    {
                        ?>
                        <option value="<?php echo $seatType->getId(); ?>"> <?php echo $seatType->getType(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Cantidad:</td>
            <td><input type="number" name="quantity" min=1 required></td>
        </tr>
        <tr>
            <td>Precio:</td>
            <td><input type="number" name="price" min=1 required></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Agregar"></td>
            <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>EventSeat/ShowListEventSeatView "> Ver Listado</a></td></tr>
        </tr>
        <tr>
            <td colspan="2"><?php echo $message; ?></td>
        </tr>
    </table>
</form>

