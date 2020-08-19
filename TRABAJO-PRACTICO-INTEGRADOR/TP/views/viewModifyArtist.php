<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for=""> MODIFICAR ARTISTA</label>
</div>
<form action="<?php echo FRONT_ROOT; ?>Artist/Modify" method="post" enctype="multipart/form-data">
    <table class="modifyList" style="margin: 10px auto; width:50%">
        <tr>
            <th colspan="2">ARTISTA</th>
        </tr>
        <tr>
            <td>id:</td>
            <td><input type="text" name="id" value="<?php echo $oArtist->getId(); ?>" readonly></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="name" value="<?php echo $oArtist->getName(); ?>"></td>
        </tr>
        <tr>
            <td>Apellido:</td>
            <td><input type="text" name="lastName" value="<?php echo $oArtist->getLastName(); ?>"></td>
        </tr>
        <tr>
            <td>Nombre Artistico:</td>
            <td><input type="text" name="artisticName" value="<?php echo $oArtist->getArtisticName(); ?>"></td>
        </tr>
        <tr>
                <td>Imagen:</td>
            <?php $photo= $oArtist->getPhoto(); ?>
            <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
        </tr>
        <tr>
            <td>Seleccionar archivo:</td>
            <td><input type="file" name="photo" id="photo"></td>
        </tr>
        <tr>
            <td colspan="2"> <input type="submit" value="Modificar"></td>
        </tr>
    </table>
</form>
</div>
