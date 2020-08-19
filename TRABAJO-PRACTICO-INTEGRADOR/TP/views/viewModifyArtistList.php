<?php require_once(VIEWS_PATH . "nav.php"); ?>



<div class="list">
<label for="">LISTADO DE ARTISTAS A MODIFICAR</label>
</div>

<table  class="modifyList" style="margin: 10px auto; width:60%">
    <tr>
        <th>id</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Nombre Artistico</th>
        <th>Imagen</th>
        <th></th>
    </tr>
<?php
    if(isset($artistList))
    {
        foreach($artistList as $artist)
        {
        ?>
            <tr>
                <td><?php echo $artist->getId();?></td>
                <td><?php echo $artist->getName();?></td>
                <td><?php echo $artist->getLastName();?></td>
                <td><?php echo $artist->getArtisticName();?></td>
                <?php $photo= $artist->getPhoto(); ?>
                <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
                <td><a href="<?php echo FRONT_ROOT . 'Artist/ModifyList/'. $artist->getId(); ?>">Modificar</a></td>
            </tr>
        <?php
        }
    }
?>
</table>


