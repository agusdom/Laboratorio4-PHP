<?php require_once(VIEWS_PATH . "nav.php"); ?>


<div class="list">
<label for="">LISTADO DE ARTISTAS</label>
</div>
<table  class="modifyList" style="margin: 10px auto; width:50%">
    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Nombre Artistico</th>
        <th>Imagen</th>
        <th>Eliminar</th>
        
    </tr>
<?php
    if(isset($artistList))
    {
        foreach($artistList as $artist)
        {
        ?>
            <tr>
                <td><?php echo $artist->getName();?></td>
                <td><?php echo $artist->getLastName();?></td>
                <td><?php echo $artist->getArtisticName();?></td>
                <?php $photo= $artist->getPhoto(); ?>
                <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
                <td><a id="delete1" href="<?php echo FRONT_ROOT.'Artist/Delete/'. $artist->getId(); ?>">Eliminar</a></td>   
        </tr>
            <?php
        }
    }
?>
    </tr>
        <td colspan="6"><?php if(isset($message)) echo $message; ?></td>
    </tr>
</table>

