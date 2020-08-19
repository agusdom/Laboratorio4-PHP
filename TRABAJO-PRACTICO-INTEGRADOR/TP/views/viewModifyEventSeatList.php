<?php require_once(VIEWS_PATH . "nav.php"); ?>


<div class="list">
<label for="">LISTADO DE PLAZA x CALENDARIO A MODIFICAR</label>
</div>
<table  class="modifyList" style="margin: 10px auto; width:90%">
    <tr>
        <th colspan="5">Calendario</th>
        <th>Asientos</th>
        <th></th>
    </tr>
    <tr>
        <th>id</th>
        <th>Fecha</th>
        <th>Evento</th>
        <th>Imagen</th>
        <th>Lugar</th> 
        <th>Lista de Asientos</th> 
        <th></th>
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
                    <td><?php echo $calendar->getId();?></td>
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
                            <?php echo "Precio: " . $oeventSeat->getPrice();?>
                            <?php echo "Cant: " . $oeventSeat->getQuantity();?>
                            <?php echo "Remanente: " . $oeventSeat->getRemains(). "<br><br>";?>
                        <?php 
                        }
                        ?>
                    </td>
                    <td><a href="<?php echo FRONT_ROOT. 'EventSeat/ModifyList/'. $calendar->getId();  ?>">Modificar</a></td>
                    <?php //devuelve id calendario para mostrarlo en el modifyEventSeatSeat?>
                </tr>
                <?php
            ?>
            <?php  
            }
        }   
    }
?>
</table>
<input type="hidden" name="idcalendario" value="<?php $calendar->getId();?>">