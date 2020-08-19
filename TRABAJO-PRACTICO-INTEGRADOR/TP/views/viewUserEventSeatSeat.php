<?php require_once(VIEWS_PATH . "navUser.php"); ?>
<div class="container1">

<form action="<?php echo FRONT_ROOT?> Basket/Add" method="post">
<table class="modifyList" style="margin: 30px auto 0px; width:60%" >
    <tr>
        <?php
            $eventSeat1= $eventSeatArray[0]; //todos tienen calendarios con el mismo evento adentro
            $calendar1= $eventSeat1->getCalendar();
            $event1= $calendar1->getEvent();
            $placeEvent1= $calendar1->getPlaceEvent();
            $photo1= $event1->getPhoto(); 
        ?>
        <th colspan="2"> <?php echo $event1->getName(). " "; ?></th>
        <th rowspan= "3"><img src="<?php echo $photo1->getPath();?>" width="200"  alt=""> </th>
        
    </tr>
    <tr>
        <th>fecha</th>
        <th><?php echo $calendar1->getDate(); ?></th>
    </tr>
    <tr>
        <th>Lugar:</th>
        <th><?php echo $placeEvent1->getName(); ?></th>
    </tr>
    </table>

    <table class="modifyList" style="margin: 10px auto 0px; width:60%">
    <tr>
        <th>Asientos</th>
        <th>Precio</th>
        <th>disponibilidad</th>
        <th>Asiento</th>
    </tr>
    <?php
    if(isset($eventSeatArray))
    {
        foreach($eventSeatArray as $eventSeat)
        {
        $seatType= $eventSeat->getSeatType();
        ?>
        <tr>
            <td><?php echo $seatType->getType(); ?></td>
            <td><?php echo "$ ".$eventSeat->getPrice(); ?></td>
            <td><?php echo $eventSeat->getRemains(). " unid."; ?></td>
           
            <td><input type="radio" class="form-radio" name="eventSeat" id="" value="<?php echo $eventSeat->getId(); ?>" required></td>
        </tr>
        <?php
        }
    }  
    ?>
    <tr>
        <td></td>
        <td >Cantidad</td>
        <td ><input type="number" name="seatQuantity" id="" min="1" value="1" required></td>
        <td></td>
    </tr>
    <tr >
        <td colspan="4"><input type="submit" value="Agregar al Carrito"></td>
    </tr>
    <tr >
        <td colspan="4"><?php echo (isset($message)) ? $message : ""; ?></td>
    </tr>
</table>
   
<!-- </table class="modifyList" style="margin: 10px auto 0px; width:40%">
    
<table> -->

</form>
</div>
