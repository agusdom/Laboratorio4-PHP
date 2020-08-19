<?php require_once(VIEWS_PATH . "nav.php"); ?>


<div class="list">
<label for="">LISTADO DE TIPOS DE PLAZA A MODIFICAR</label>
<table class="modifyList" style="margin: 10px auto; width:30%">
    <tr>
        <th>id</th>
        <th>Tipo</th>
        <th></th>
    </tr>
<?php
if(isset($seatTypeList))
{
    foreach($seatTypeList as $seatType)
    {
    ?>
        <tr>
            <td><?php echo $seatType->getId();?></td>
            <td><?php echo $seatType->getType();?></td>
            <td><a href="<?php echo FRONT_ROOT . 'SeatType/ModifyList/'. $seatType->getId(); ?>">Modificar</a></td>
        </tr>
    <?php
    }
}
?>
</table>
</div>

