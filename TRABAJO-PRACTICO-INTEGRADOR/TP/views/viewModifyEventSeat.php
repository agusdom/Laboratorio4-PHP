<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">LISTADO DE PLAZA x CALENDARIO A MODIFICAR</label>
</div>

    <form action="<?php echo FRONT_ROOT; ?>EventSeat/Modify" method="post">
        <table class="modifyList" style="margin: 10px auto; width:30%">
            <?php $seatype= $oEventSeat->getSeatType(); ?>
            <tr>
                <th colspan="2"><?php echo "Plaza: &nbsp ".ucfirst($seatype->getType());?></th>
            </tr>
            <tr>
                <td>Precio: </td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $oEventSeat->getId();?>" id="">
                    <input type="text" name="price" value="<?php echo $oEventSeat->getPrice();?>">
                </td>
           </tr>
           <tr>
                <td>Cantidad: </td>
                <td><input type="text" name="quantity" value="<?php echo $oEventSeat->getQuantity();?>"></td>
           </tr>
           <tr>
                <td>Remanente: </td>
                <td>
                    <input type="text" name="remains" value="<?php echo $oEventSeat->getRemains();?>">
                    <?php
                    $calendar= $oEventSeat->getCalendar();
                    ?>
                    <input type="hidden" name="calendarId" value="<?php echo $calendar->getId();?>" id="">
                    <input type="hidden" name="seatTypeId" value="<?php echo $seatype->getId();?>" id="">
                </td>
           </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Modificar"></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $message; ?></td>
            </tr>
        </table>
    </form>
</div>
