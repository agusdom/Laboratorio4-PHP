<?php require_once(VIEWS_PATH . "nav.php"); ?>


<div class="list">
<label for="">LISTADO DE EVENTOS A MODIFICAR</label>
</div>
<table  class="modifyList" style="margin: 10px auto; width:40%">
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Imagen</th>
        <th></th>
    </tr>
<?php
if(isset($eventList))
{
    foreach($eventList as $event)
    {
    ?>
        <tr>
            <td><?php echo $event->getId();?></td>
            <td><?php echo $event->getName();?></td>
            <?php $photo= $event->getPhoto(); ?>
            <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
            <td><a href="<?php echo FRONT_ROOT . 'Event/ModifyList/'. $event->getId(); ?>">Modificar </a></td>
        </tr>
    <?php
    }
}
?>
</table>


