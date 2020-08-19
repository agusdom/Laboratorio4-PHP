<?php require_once(VIEWS_PATH . "nav.php"); ?>


<div class="list">
<label for="">LISTADO DE ASIENTOS x CALENDARIO</label>
</div>
<table class="modifyList" style="margin: 10px auto; width:95%">
    <tr>
        <th colspan="4">Calendario</th>
        <th>Asientos</th>
    </tr>
    <tr>
        <th>Fecha</th>
        <th>Evento</th>
        <th>Imagen</th>
        <th>Lugar</th> 
        <th>Lista de Asientos</th> 
    </tr>
<?php
    $calendarIdArray= array();
    if(isset($eventSeatList))
    { 
        foreach($eventSeatList as $eventSeat)
        {   
            $calendar= $eventSeat->getCalendar();
            
            if(!in_array($calendar->getId(), $calendarIdArray))
            {
                array_push($calendarIdArray, $calendar->getId());
                $eventSeatList1= array();
                $eventSeatList1= $this->eventSeatDao->GetByCalendarId($calendar->getId());
                ?>
                <tr>
                    <td><?php echo $calendar->getDate();?></td>
                    <?php
                    $event= $calendar->getEvent();
                    ?>
                    <td><?php echo $event->getName();?></td>
                    <?php $photo= $event->getPhoto(); ?>
                    <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=50;this.width=50" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
                    <?php $placeEvent= $calendar->getPlaceEvent(); ?>
                    <td><?php echo $placeEvent->getName();?></td>
                    <td>
                    <?php
                        foreach($eventSeatList1 as $oeventSeat)
                        {
                        ?>
                            <?php $oSeatType= $oeventSeat->getSeatType();?>
                            <?php echo "Tipo Asiento: " . $oSeatType->getType();?>
                            <?php echo "&nbsp &nbsp Precio: $ " . $oeventSeat->getPrice();?>
                            <?php echo "&nbsp &nbsp Cant: " . $oeventSeat->getQuantity();?>
                            <?php echo "&nbsp &nbsp Remanente: " . $oeventSeat->getRemains(). "<br><br>";?>
                        <?php 
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }  
        }   
    }
?>
</table>


