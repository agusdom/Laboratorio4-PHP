<?php
include('header.php');
include('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Listado de clientes</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>id</th>
                         <th>Nombre</th>
                         <th>Apellido</th>
                         <th>Dni</th>
                         <th>Email</th>
                         <th>Direccion</th>
                         <th>Foto</th>
                         
                    </thead>
                    <tbody>
                         <?php
                         if(isset($clientList))
                         {
                              foreach($clientList as $client)
                              {
                                   ?>
                                   <tr>
                                        <td> <?php echo $client->getClientId(); ?></td>
                                        <td> <?php echo $client->getFirstName(); ?></td>
                                        <td> <?php echo $client->getLastName(); ?></td>
                                        <td> <?php echo $client->getDni(); ?></td>
                                        <td> <?php echo $client->getEmail(); ?></td>
                                        <td> <?php echo $client->getAddress(); ?></td>
                                        <?php
                                        $photo=  $client->getPicture();
                                        ?>
                                        <td> <img src="<?php echo $photo->getPath() ?>" width="100" alt=""></td>
                                   </tr>
                                   <?php
                              }
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </section>

     <section id="eliminar">
          <div class="container">
               <h2 class="mb-4">Eliminar cliente</h2>

               <form action="<?php echo FRONT_ROOT?>Client/DeleteClient" method="post" class="form-inline bg-light-alpha p-5">
                    <div class="form-group text-white">
                         <label for="">DNI</label>
                         <input type="text" name="dni" value="" class="form-control ml-3">
                    </div>
                    <button type="submit" name="button" class="btn btn-danger ml-3">Eliminar</button>
               </form>
          </div>
     </section>

</main>

<?php include('footer.php') ?>
