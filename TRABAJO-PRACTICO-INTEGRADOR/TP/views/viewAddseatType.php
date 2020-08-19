<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CARGAR TIPO DE PLAZA</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>SeatType/Add" method="post">
    <table class="modifyList" style="margin: 10px auto; width:35%">
        <tr>
            <th colspan="2">TIPO DE PLAZA</th>
        </tr>
        <tr>
            <td>Nombre Plaza: </td>
            <td><input type="text" name="type" id=""></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Agregar"></td>
            <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>SeatType/ShowListSeatTypeView "> Ver Listado Asientos</a></td></tr>
        </tr>
        <tr>
            <td colspan="2"><?php if(isset($message)){echo $message;} ?></td>
        </tr>
    </table>
</form>
