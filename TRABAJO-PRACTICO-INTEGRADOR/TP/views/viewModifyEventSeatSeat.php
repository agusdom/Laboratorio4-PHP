<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list"><label for="">MODIFICAR PLAZA x CALENDARIO</label>
</div>

    <form action="<?php echo FRONT_ROOT; ?>EventSeat/ModifySeat" method="post">
    <table class="modifyList" style="margin: 10px auto; width:60%">
        <tr>
            <th colspan="5"> CALENDARIO</th>
        </tr>
        <tr>
            <th>Id</th>
            <th>Fecha</th>
            <th>Evento</th>
            <th>Imagen</th>
            <th>Lugar</th>
        </tr>
        <tr>
            <td><?php echo $oCalendar->getId(); ?></td>
            <td><?php echo $oCalendar->getDate(); ?></td>
            <?php $event= $oCalendar->getEvent();?>
            <td> <?php echo $event->getName(); ?></td>
            <?php $photo= $event->getPhoto(); ?>
            <td><img src="<?php echo $photo->getPath();?>" width="100" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=100;this.height=100" alt=""></td>
            <?php $placeEvent= $oCalendar->getPlaceEvent();?>
            <td><?php echo $placeEvent->getName(); ?></td>
        </tr>
</table>
<table class="modifyList" style="margin: 10px auto; width:60%">
        <tr>
            <th colspan="6">SELECCIONAR TIPO DE PLAZA</th>
        </tr>
        <tr>
            <th>id</th>
            <th>Tipo</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Remanente</th>
            <th></th>
        </tr>
        <?php
        $eventSeatList1= $this->eventSeatDao->GetByCalendarId($oCalendar->getId());
        ?>
        <?php
            foreach($eventSeatList1 as $eventSeat) 
            {
                $seatType= $eventSeat->getSeatType();
            ?>
                <tr>
                    <td><?php echo $eventSeat->getId(); ?></td>
                    <td><?php echo $seatType->getType(); ?></td>
                    <td><?php echo $eventSeat->getPrice(); ?></td>
                    <td><?php echo $eventSeat->getQuantity(); ?></td>
                    <td><?php echo $eventSeat->getRemains(); ?></td>
                    <td><a href="<?php echo FRONT_ROOT.'EventSeat/ModifySeat/'. $eventSeat->getId(); ?>">Seleccionar</a></td>   
                   
                </tr>
            <?php
            }  
        ?>
        </tr>
            <td colspan="6"><?php if(isset($message)) echo $message; ?></td>
        </tr>
    </table>

