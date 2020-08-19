<?php require_once(VIEWS_PATH . "nav.php"); ?>

<div class="list">
<label for="">CALENDARIO A MODIFICAR</label>
</div>
    <form action="<?php echo FRONT_ROOT; ?>Calendar/Modify" method="post">
        <table class="modifyList" style="margin: 10px auto; width:30%">
            <tr>
                <th colspan="2">CALENDARIO</th>
            </tr>
            <tr>
                <td>Fecha:</td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $oCalendar->getId(); ?>"> 
                    <?php date_default_timezone_set("America/Argentina/Buenos_Aires");?>
                    <input type="date" name="date" value="<?php echo $oCalendar->getDate(); ?>">
                </td>
            </tr>
            <tr>
                <td>Evento:</td>
                <td>
                    <select id="select1" name="event" id="">
                        <?php
                        $oEvent= $oCalendar->getEvent();
                        if(isset($eventList))
                        {
                            foreach($eventList as $event)
                            {    
                                ?>
                                <option value="<?php echo $event->getId(); ?>" <?php if($event->getId() == $oEvent->getId()){echo "selected";} ?>> <?php echo $event->getName(); ?></option>
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
                        $oPlaceEvent= $oCalendar->getPlaceEvent();
                        if(isset($placeEventList))
                        {
                            foreach($placeEventList as $placeEvent)
                            {
                                ?>
                                <option value="<?php echo $placeEvent->getId(); ?>"  <?php if($placeEvent->getId() == $oPlaceEvent->getId()){echo "selected";} ?>> <?php echo $placeEvent->getName(); ?></option>
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

                        $artistList1= $oCalendar->getArtistList();
                        if(isset($artistList))
                        {
                            foreach($artistList as $artist)
                            {
                                $band=0;
                                foreach($artistList1 as $artist2)
                                {
                                    if($artist2->getId() == $artist->getId())
                                    {
                                        $band= 1;
                                    }
                                }
                                ?>
                                <option value="<?php echo $artist->getId(); ?>"  <?php if($band == 1){echo "selected";} ?> > <?php echo $artist->getName(); ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"> <input type="submit" value="Modificar"></td>
            </tr>
            <tr>
                <td colspan="2"><?php if(isset($message)){echo $message;} ?></td>
            </tr>
        </table>
    </form>

