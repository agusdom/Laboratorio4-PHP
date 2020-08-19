<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
    <label for="">CARGAR CALENDARIO</label>
</div>

    <form action="<?php echo FRONT_ROOT; ?>Calendar/Add" method="post">
        <table class="modifyList" style="margin: 10px auto; width:30%">
            <tr>
                <th colspan="2">CALENDARIO</th>
            </tr>
            <tr>
                <td>Fecha:</td>
                <?php date_default_timezone_set("America/Argentina/Buenos_Aires");?>
                <td><input type="date" name="date" value="<?php echo date('Y-m-d'); ?>" min= "<?php echo date('Y-m-d'); ?>"></td>
            </tr>
            <tr>
                <td>Evento:</td>
                <td>
                    <select id="select1" name="event" id="">
                    <?php
                        if(isset($eventList))
                        {
                            foreach($eventList as $event)
                            {
                                ?>
                                <option value="<?php echo $event->getId(); ?>"> <?php echo $event->getName(); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Lugar:</td>
                <td>
                    <select id="select1" name="placeEvent" id="">
                        <?php
                        if(isset($placeEventList))
                        {
                            foreach($placeEventList as $placeEvent)
                            {
                                ?>
                                <option value="<?php echo $placeEvent->getId(); ?>"> <?php echo $placeEvent->getName(); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Artistas:</td>
                <td>
                    <select id="select2" name="artist[]" multiple>
                        <?php //el name del select multiple lleva corchete si o si
                        if(isset($artistList))
                        {
                            foreach($artistList as $artist)
                            {
                                ?>
                                <option value="<?php echo $artist->getId(); ?>"> <?php echo $artist->getName(); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Agregar"></td>
                <tr><td colspan="2"><a href="<?php echo FRONT_ROOT; ?>Calendar/ShowListCalendarView "> Ver Calendarios</a></td></tr>
            </tr>
            <tr>
                <td colspan="2"><?php echo $message; ?></td>
            </tr>
        </table>
    </form>

