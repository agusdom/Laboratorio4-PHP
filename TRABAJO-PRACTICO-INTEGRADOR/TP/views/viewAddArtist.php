<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CARGAR ARTISTA</label>
</div>

<form  action="<?php echo FRONT_ROOT; ?>Artist/Add" method="post" enctype="multipart/form-data">
    <table class="modifyList" style="margin: 10px auto; width:50%">
        <tr>
            <th colspan="2">ARTISTA</th> 
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><input type="text" name="nombre" required></td>
        </tr>
        <tr>
            <td>Apellido:</td>
            <td><input type="text" name="lastName" required></td>
        </tr>
        <tr>
            <td>Nombre Artistico:</td>
            <td><input type="text" name="artisticName" required></td>
        </tr>
        <tr>
            <td>Seleccionar archivo:</td>
            <td><input type="file" name="photo" id="photo"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="BTNAddArtist" value="Cargar"></td>
        </tr>
        <tr>
            <td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Artist/ShowListArtistView "> Ver Listado Artistas</a></td>
        </tr>
        </tr>
        <td colspan="2"><?php if(isset($message)) echo $message; ?></td>
    </tr>
    </table>
</form>
