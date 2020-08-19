<?php 
//el viewDeleteEventSeatCalendar.php y el viewDeleteEventSeatSeat.php son los dos 
//archivos encargados del borrado de eventSeat 
?>
<?php require_once(VIEWS_PATH . "nav.php"); ?>
<div class="list">
    <label for="">ELIMINAR PLAZA x CALENDARIO</label>
</div>


<table class="modifyList" style="margin: 10px auto; width:80%">
<tr>
    <th COLSPAN="6">SELECCIONAR CALENDARIO</th>
</tr>
<tr>
    <th>Fecha</th>
    <th>Evento</th>
    <th>Imagen</th>
    <th>Lugar</th>
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
                <a href="<?php echo FRONT_ROOT; ?> EventSeat/DeleteByCalendarSelection/ <?php echo $calendar->getId(); ?> "> Seleccionar</a>
                </td>
            </tr>
            <?php
        }  
    }   
}

?>
</table>
   
