<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">LISTADO DE CALENDARIOS</label>
</div>
<table class="modifyList" style="margin: 10px auto; width:70%">
    <tr>
        <th>Fecha</th>
        <th>Evento</th>
        <th>Imagen</th>
        <th>Lugar</th>
        <th>Listado de Artistas</th>
        <th>Eliminar</th>
    </tr>
<?php
if(isset($calendarList))
{
    foreach($calendarList as $calendar)
    {
    ?>
        <tr>
            <td><?php echo $calendar->getDate();?></td>
            <?php
            $event= $calendar->getEvent();
            ?>
            <td><?php echo $event->getName();?></td>
            <?php $photo= $event->getPhoto(); ?>
            <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
            <?php $placeEvent= $calendar->getPlaceEvent(); ?>
            <td><?php echo $placeEvent->getName();?></td>
            <td>
                <ul>
                    <?php
                    foreach($calendar->getArtistList() as $artist)
                    {
                        ?>
                        <li>
                        <?php echo $artist->getArtisticName(); ?>
                        </li>
                    <?php
                    }
                    
                    ?>
                </ul>
            </td>
            <td><a id="delete1" href="<?php echo FRONT_ROOT.'Calendar/Delete/'. $calendar->getId(); ?>">Eliminar</a></td>
        </tr>
    <?php
    }
}
?>
</tr>
        <td colspan="6"><?php if(isset($message)) echo $message; ?></td>
    </tr>
</table>


