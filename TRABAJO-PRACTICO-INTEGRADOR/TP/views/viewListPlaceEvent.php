<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">LISTADO DE LUGARES DE EVENTO</label>
</div>

<table  class="modifyList" style="margin: 10px auto; width:35%">
    <tr>
        <th>Nombre</th>
        <th>Capacidad</th>
        <th>Eliminar</th>
    </tr>
<?php
if(isset($placeEventList))
{
    foreach($placeEventList as $placeEvent)
    {
    ?>
        <tr>
            <td><?php echo $placeEvent->getName();?></td>
            <td><?php echo $placeEvent->getCapacity();?></td>
            <td><a id="delete1" href="<?php echo FRONT_ROOT.'PlaceEvent/Delete/'. $placeEvent->getId(); ?>">Eliminar</a></td> 
        </tr>
    <?php
    }
}
?>
<tr>
            <td colspan="6"><?php if(isset($message)){echo $message;} ?></td>
        </tr>
</table>
