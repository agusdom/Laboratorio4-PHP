<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">LISTADO DE CATEGORIAS A MODIFICAR</label>
</div>

<table class="modifyList" style="margin: 10px auto; width:50%">
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th></th>
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
            <td><a href="<?php echo FRONT_ROOT . 'Category/ModifyList/'. $category->getId(); ?>">Modificar</a></td>
        </tr>
    <?php
    }
}
?>
</table>
</div>
</div>
