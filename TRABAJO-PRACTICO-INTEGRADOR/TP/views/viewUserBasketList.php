<?php require_once(VIEWS_PATH . "navUser.php"); ?>

<?php
/*echo "<pre>";
var_dump($basketList);
echo "</pre>";*/
    if((isset($basketList)))
    {
        $purchase= $basketList;
        $purchaseRowArray= $purchase->getPurchaseRowList();
        
        if(count($purchaseRowArray)!=0)
        {
            $total=0;
            ?>
            <table class="modifyList" style="margin: 30px auto; width:80%" border="1">
                <tr>
                    <th colspan="8">CARRITO DE COMPRAS</th>
                </tr>
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>T. asiento</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th>Cancelar</th>
                </tr>
            <?php
            
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
                    <td><?php echo $purchaseRow->getPrice();?></td>
                    <?php
                    $subtotal= $purchaseRow->getPrice() * $purchaseRow->getQuantity(); 
                    ?>
                    <td><?php echo $subtotal;?></td>
                    <td><a id="delete1" href="<?php echo FRONT_ROOT . 'Basket/DeleteRow/'. $purchaseRow->getId(); ?>"> Eliminar</a></td>
                </tr>
                <?php
                $total= $total + $subtotal;
            }
            ?>
            <tr>
                <td colspan="6" style= "text-align:right; font-size:20px; font-weight:bold ">Total</td>
                <td  style= "text-align:right; font-size:20px; font-weight:bold "><?php echo $total;?></td> 
                <td></td>

            </tr>
            <tr>
                <td colspan="6"></td>
                <td colspan="2" style="text-align:right;" ><a id="importantLink" href="<?php echo FRONT_ROOT;?> Purchase/Add " >COMPRAR TODO</a></td>
            </tr>
            </table>
            <label for=""><?php if(isset($message)) echo $message;?></label>
            <?php
        }
        else
        {
            echo "El carrito esta vacio <br>";
            ?><a href="<?php echo FRONT_ROOT; ?>Home/ShowUserHomeView">Volver al inicio</a><?php 
        }
    }
    else
        {
            echo "El carrito esta vacio <br>";
            ?><a href="<?php echo FRONT_ROOT; ?>Home/ShowUserHomeView">Volver al inicio</a><?php 
        }
    
    
    
?>
</table>



