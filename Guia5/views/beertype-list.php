
<?php 
include_once('header.php');
include_once('nav-bar.php');
?>

<div id="breadcrumb" class="hoc clear"> 
    <h6 class="heading">Listado de Tipos de Cervezas</h6>
  </div>
</div>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT ?>BeerType/Delete" method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 100px;">Codigo</th>
              <th style="width: 150px;">Nombre</th>
              <th style="width: 450px;">Descripción</th>
              <th style="width: 450px;">Receta</th>
              <th style="width: 100px;">Eliminar</th>
            </tr>
          </thead>
          <tbody>
          <?php 
              if(isset($beerTypeList))
              {
                foreach($beerTypeList as $beerType)
                {
            ?>
              <tr>
                <td><?php echo $beerType->getBeerTypeCode()?></td>
                <td><?php echo $beerType->getName()?></td>
                <td><?php echo $beerType->getDescription()?></td>
                <td><?php echo $beerType->getRecipe()?></td>          
                <td style="text-align: center;">
                  <a class="btn" href="<?php echo FRONT_ROOT; ?>BeerType/Delete/<?php echo $beerType->getBeertypeCode(); ?>"> <i class="far fa-trash-alt"></i></a>
                </td>
              </tr>
          <?php
                }
              }
          ?>
          </tbody>
        </table></form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
include_once('footer.php');
?>
  