<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">LISTADO DE TIPOS DE PLAZA</label>
</div>
<table class="modifyList" style="margin: 10px auto; width:30%">    
    <tr>
        <th>id</th>
        <th>Tipo</th>
        <th>Eliminar</th>
    </tr>
<?php
if(isset($seatTypeList))
{
    foreach($seatTypeList as $seat)
    {
    ?>
        <tr>
            <td><?php echo $seat->getId();?></td>
            <td><?php echo $seat->getType();?></td>
            <td><a id="delete1" href="<?php echo FRONT_ROOT.'SeatType/Delete/'. $seat->getId(); ?>">Eliminar</a></td>
        </tr>
    <?php
    }
}
?>
<tr>
            <td colspan="6"><?php if(isset($message)){echo $message;} ?></td>
        </tr>
</table>

