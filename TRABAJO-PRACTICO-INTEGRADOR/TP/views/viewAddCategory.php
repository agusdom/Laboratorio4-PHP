<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">AGREGAR CATEGORIA</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>Category/Add" method="post">
    <table class="modifyList" style="margin: 10px auto; width:40%">
        <tr>
            <th colspan="2">CATEGORIA</th>            
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" id="" require></td>
        </tr>
        <tr>
            <td>Descripcion:</td>
            <td><input type="text" name="description" id="" require></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Agregar"></td>
            <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Category/ShowListCategoryView "> Ver Listado Categorias</a></td></tr>
        </tr> 
        <tr>
            <td colspan="2"><?php if(isset($message))echo $message; ?></td>
        </tr>
    </table>
</form>
        

