<?php require_once(VIEWS_PATH . "navUser.php"); ?>

<!-- <div class="container1"> -->
<form action="<?php echo FRONT_ROOT;?>Home/FilterEvent" method="post">
<div class="list">
<label for="">LISTADO DE EVENTOS</label>
</div>
<table  class="modifyList" style="margin: 15px 30px 0px 150px; float: left">
    <tr>
        <th colspan="2">SELECCIONE UN FILTRO</th>  
    </tr>
    <tr>
        <td>Artista:</td>
        <td>
            <select name="artist" id="select1">
                <option value=""></option>
                <?php
                if(isset($artistList))
                {
                    foreach($artistList as $artist)
                    {
                        ?>
                        <option value="<?php echo $artist->getId();?>"><?php echo $artist->getArtisticName();?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Categoria:</td>
        <td>
            <select name="category" id="select1">
                <option value=""></option>
                <?php
                if(isset($categoryList))
                {
                    foreach($categoryList as $category)
                    {
                        ?>
                        <option value="<?php echo $category->getId();?>"><?php echo $category->getName();?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2"> (opcional) fechas: </td>
    </tr>
    <tr>
        <?php date_default_timezone_set("America/Argentina/Buenos_Aires");?>
        <td>Desde:</td>
        <td><input type="date" name="date1" min= "<?php echo date('Y-m-d'); ?>"></td>
    </tr>
    <tr>
        <td>Hasta:</td>
        <td><input type="date" name="date2" min= "<?php echo date('Y-m-d'); ?>"></td>
    </tr>
    <tr>
        <td colspan= "2"><input type="submit" value="Filtrar"></td>
    </tr>
    <tr>
        <td colspan="2"><?php if(isset($message)) echo $message; ?></td>
    </tr>
</table>
</form>



<table  class="modifyList" style="margin: 15px 10px; float: left">
    <tr>
        <th>Nombre</th>
        <th>Imagen</th>
        <th></th>
    </tr>
    <?php
    //var_dump($eventList);
    if(isset($eventList))
    {
        foreach($eventList as $event)
        {
        ?>
            <tr>
                <td><?php echo $event->getName();?></td>
                <?php $photo= $event->getPhoto(); ?>
                <td><img src="<?php echo $photo->getPath();?>" width="50" onclick="javascript:this.height=100;this.width=100" ondblclick="javascript:this.width=50;this.height=50" alt=""></td>
                <td><a href="<?php echo FRONT_ROOT.'Home/DisplayEventSeatCalendars/'. $event->getId(); ?>"> Seleccionar</a></td>
            </tr>
        <?php
        }
    }        
    ?>
</table>

<!-- </div> -->
