
<?php 
  include_once('header.php');
  include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Listado de Cervezas</h6>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
        <!-- <form action="" method=""> -->
          <table style="text-align:center;">
            <thead>
              <tr>
                <th style="width: 100px;">Codigo</th>
                <th style="width: 170px;">Nombre</th>
                <th style="width: 120px;">Tipo</th>
                <th style="width: 400px;">Descripcion</th>
                <th style="width: 110px;">Dens. Alcohol</th>
                <th style="width: 130px;">Origen</th>
                <th style="width: 100px;">Precio $ </th>
                <th style="width: 100px;">Eliminar</th>
              </tr>
            </thead>
            <tbody>
              
              <?php 
                if(isset($beerList))
                {
                    foreach($beerList as $beer)
                    {
              ?>
                <tr>
                  <td><?php echo $beer->getBeerCode() ?></td>
                  <td><?php echo $beer->getName() ?></td>
                  <td><?php echo $beer->getBeerType()->getName() ?></td>
                  <td><?php echo $beer->getDescription() ?></td>
                  <td><?php echo $beer->getDensity() ?></td>
                  <td><?php echo $beer->getOrigin() ?></td>
                  <td><?php echo $beer->getPrice() ?></td>
                  <td>
                    <a class="btn" href="<?php echo FRONT_ROOT; ?>Beer/Delete/<?php echo $beer->getBeerCode(); ?>"> <i class="far fa-trash-alt"></i></a>
                  </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
          </table>
        <!-- </form>  -->
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include_once('footer.php');
?>
  