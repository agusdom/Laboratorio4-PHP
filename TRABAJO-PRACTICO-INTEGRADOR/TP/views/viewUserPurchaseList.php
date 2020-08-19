<?php require_once(VIEWS_PATH . "navUser.php"); ?>





<?php
if((isset($purchaseList)) && (Count($purchaseList)!= 0))
{
    $total=0;
    
    foreach($purchaseList as $purchase)
    {
        $total=0;
        $user= $purchase->getUser();
        if($userList->getEmail()===$user->getEmail())
        {
        ?>
        <table class="modifyList" style="margin: 10px auto 0px auto; width:90%" >
        <tr>
            <th colspan="8">COMPRA</th>
        </tr>
        <tr>
            <th>Cliente</th>
            <th>Fecha compra</th>
            <th>Compra Nro.</th>  
            <th colspan="5" rowspan="2"></th>
        </tr>
        <tr>
            <td><?php echo $user->getName(). " " . $user->getLastName();?></td>
            <td><?php echo $purchase->getDate();?></td>
            <td><?php echo $purchase->getId();?></td>
        </tr>
        <tr>
            <th>Evento</th>
            <th>Fecha Evento</th>
            <th>Lugar</th>
            <th>T. Asiento</th>
            <th>Cant.</th>
            <th>$ x Unid</th>
            <th>Subtotal</th>
            <th></th>
        </tr>
        <?php
        $purchaseRowArray= $purchase->getPurchaseRowList();
        
        
        foreach($purchaseRowArray as $purchaseRow)
        {
            $eventSeat= $purchaseRow->getEventSeat();
            $calendar= $eventSeat->getCalendar();
            $seatType= $eventSeat->getSeatType();
            $event= $calendar->getEvent();
            $placeEvent= $calendar->getplaceEvent(); 
            ?>
            <tr>
                <td><?php echo $event->getName();?></td>
                <td><?php echo $calendar->getDate();?></td>
                <td><?php echo $placeEvent->getName();?></td>
                <td><?php echo $seatType->getType();?></td>
                <td><?php echo $purchaseRow->getQuantity();?></td>
                <td><?php echo "$ ".$purchaseRow->getPrice();?></td>
                <?php
                $subtotal= $purchaseRow->getPrice() * $purchaseRow->getQuantity(); 
                ?>
                <td><?php echo "$ ".$subtotal;?></td>
                <td><a href="<?php echo FRONT_ROOT.'Purchase/ShowTiketView/'. $purchaseRow->getId(); ?>" target="_blank">Ver Ticket</a></td>
            </tr>
            <?php
            $total= $total + $subtotal;
        }
    
        ?>
        <tr>
            <td colspan="6" style= "text-align:right; font-size:20px; font-weight:bold ">Total</td>
            <td  style= "text-align:right; font-size:20px; font-weight:bold "><?php echo "$ ". $total;?></td>
            <td></td>
        </tr>
        </table>
        <br>
        <?php
    }
    }
    ?>
    
    <label for=""><?php if(isset($message)) echo $message;?></label>
    <?php
}
else
{
    ?><a href="<?php echo FRONT_ROOT; ?>Home/ShowUserHomeView">Volver al inicio</a><?php 
}
?>




