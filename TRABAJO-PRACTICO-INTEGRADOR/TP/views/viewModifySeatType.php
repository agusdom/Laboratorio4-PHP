<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">MODIFICAR TIPO DE PLAZA</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>SeatType/Modify" method="post">
    <table class="modifyList" style="margin: 10px auto; width:30%">
        <tr>
            <th colspan="2">TIPO DE PLAZA</th>
        </tr>
        <tr>
            <td>id:</td>
            <td><input type="text" name="id" value="<?php echo $oSeatType->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Tipo:</td>
            <td><input type="text" name="type" value="<?php echo $oSeatType->getType(); ?>"></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>
</form>
