<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">LISTADO DE LUGARES DE EVENTO A MODIFICAR</label>
</div>

<table class="modifyList" style="margin: 10px auto; width:40%">
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Capacidad</th>
        <th></th>
    </tr>
<?php
if(isset($placeEventList))
{
    foreach($placeEventList as $placeEvent)
    {
    ?>
        <tr>
            <td><?php echo $placeEvent->getId();?></td>
            <td><?php echo $placeEvent->getName();?></td>
            <td><?php echo $placeEvent->getCapacity();?></td>
            <td><a href="<?php echo FRONT_ROOT . 'PlaceEvent/ModifyList/'. $placeEvent->getId(); ?>">Modificar</a></td>
        </tr>
    <?php
    }
}
?>
</table>

