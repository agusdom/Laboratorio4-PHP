<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">LISTADO DE CALENDARIOS A MODIFICAR</label>
</div>
<table class="modifyList" style="margin: 10px auto; width:80%">
    <tr>
        <th>id</th>
        <th>Fecha</th>
        <th>Evento</th>
        <th>Lugar</th>
        <th>Listado de Artistas</th>
        <th></th>
    </tr>
<?php
if(isset($calendarList))
{
    foreach($calendarList as $calendar)
    {
    ?>
        <tr>
            <td><?php echo $calendar->getId();?></td>
            <td><?php echo $calendar->getDate();?></td>
            <?php
            $event= $calendar->getEvent();
            ?>
            <td><?php echo $event->getName();?></td>
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
            <td>
                <a href="<?php echo FRONT_ROOT; ?> Calendar/ModifyList/ <?php echo $calendar->getId(); ?> "> Modificar</a>
            </td>
        </tr>
    <?php
    }
}
?>
</table>

