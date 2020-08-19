<?php require_once(VIEWS_PATH . "navUser.php"); ?>

<table  class="modifyList" style="margin: 30px auto 0">
    <tr>
        <?php
            $eventSeat1= $eventSeatArray[0]; //todos tienen calendarios con el mismo evento adentro
            $calendar1= $eventSeat1->getCalendar();
            $event1= $calendar1->getEvent();
            $photo1= $event1->getPhoto(); 
        ?>
        <th colspan="2">Calendario de: <?php echo $event1->getName(). " "; ?></th>
        <th><img src="<?php echo $photo1->getPath();?>" width="200"  alt=""> </th>
    </tr>
    <tr>
        <th>Fecha</th>
        <th>Lugar</th> 
        <th></th>
    </tr>
<?php
    $calendarIdArray= array();
    
    foreach($eventSeatArray as $eventSeat)
    {   
        $calendar= $eventSeat->getCalendar();
        
        if(!in_array($calendar->getId(), $calendarIdArray))
        {
            array_push($calendarIdArray, $calendar->getId());
            ?>
            <tr>
                <td><?php echo $calendar->getDate();?></td>
                
                <?php $placeEvent= $calendar->getPlaceEvent(); ?>
                
                <td><?php echo $placeEvent->getName();?></td>
                <td><a href="<?php echo FRONT_ROOT . 'Home/DisplayEventSeatSeats/'. $calendar->getId();?>"> Seleccionar</a></td>
            </tr>
        <?php  
        }
    }   
?>
</table>

