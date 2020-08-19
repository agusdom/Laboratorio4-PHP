<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">EVENTO A MODIFICAR</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>Event/Modify" method="post" enctype="multipart/form-data">
    <table class="modifyList" style="margin: 10px auto; width:40%">
        <tr>
            <th colspan="2"> EVENTO</th>
        </tr>
        <tr>
            <td>Id:</td>
            <td><input type="text" name="id" value="<?php echo $oEvent->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oEvent->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Imagen:</td>
        <?php $photo= $oEvent->getPhoto(); ?>
        <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
        </tr>

        <tr>
            <td>Tipo de Categoria:</td>
            <td>
                <?php $oCategory= $oEvent->getCategory(); ?>
                
                <select id="select1" name="categoryType" id="">
                <?php
                if(isset($categoryList))
                {
                    foreach($categoryList as $category)
                    {
                    ?>
                        <option value="<?php echo $category->getId();?>" <?php if($category->getName() == $oCategory->getName()){echo "selected";}  ?>> <?php echo $category->getName();?></option>
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
            <td colspan="2"><input type="submit" value="Guardar Cambios"></td>
        </tr>
        <tr>
            <td colspan="2"><?php echo $message; ?></td>
        </tr>
    </table>
</form>


