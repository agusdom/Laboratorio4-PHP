<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">LISTADO DE CATEGORIAS </label>
</div>

<table  class="modifyList" style="margin: 10px auto; width:40%">
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Eliminar</th>
        
    </tr>
<?php
if(isset($categoryList))
{
    foreach($categoryList as $category)
    {
    ?>
        <tr>
            <td><?php echo $category->getId();?></td>
            <td><?php echo $category->getName();?></td>
            <td><?php echo $category->getDescription();?></td>
            <td><a id="delete1" href="<?php echo FRONT_ROOT.'Category/Delete/'. $category->getId(); ?>">Eliminar</a></td>  
    </tr>
        <?php
    }
}
?>
</tr>
        <td colspan="6"><?php if(isset($message)) echo $message; ?></td>
    </tr>
</table>


