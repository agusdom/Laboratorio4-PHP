<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">AGREGAR EVENTO</label>
</div>

<form action="<?php echo FRONT_ROOT; ?>Event/Add" method="post" enctype="multipart/form-data" >
    <table class="modifyList" style="margin: 10px auto; width:50%">
        <tr>
            <th colspan="2">EVENTO</th>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" id=""></td>
        </tr>
        <tr>
            <td>Tipo de Categoria:</td>
            <td>
                <select id="select1" name="categoryId" id="">
                    <?php
                    if(isset($categoryList))
                    {
                        foreach($categoryList as $category)
                        {
                            ?>
                            <option value="<?php echo $category->getId(); ?>"> <?php echo $category->getName(); ?></option>
                            <?php
                        }
                    }
                    ?>
                    
                </select>
            </td>
        </tr>
        <tr>
            <td>Seleccionar archivo:</td>
            <td><input type="file" name="photo" id="photo"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="Agregar"></td>
            <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Event/ShowListEventView "> Ver Listado Eventos</a></td></tr>
        </tr>
        <tr>
            <td colspan="2"><?php echo $message; ?></td>
        </tr>
    </table>
</form>

