<?php
include('header.php');
include('nav.php');
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Agregar cliente</h2>
               <form action="<?php echo FRONT_ROOT. 'Client/Add' ?>" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Categoría</label>
                                       
                                   <select name="category" class="form-control">
                                        <?php
                                        if(isset($categoryList))
                                        {
                                             foreach($categoryList as $category)
                                             {
                                                  $active= $category->getIsActive();
                                                  
                                                  if($active == 1)
                                                  {
                                                       ?>
                                                       <option value="<?php echo $category->getCategoryId(); ?>"> <?php echo $category->getDescription(); ?> </option>
                                                       <?php
                                                  }
                                             }
                                        }
                                        
                                        ?>
                                        
     
                                   </select>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Apellido</label>
                                   <input type="text" name="lastName" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Nombre</label>
                                   <input type="text" name="firstName" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">DNI</label>
                                   <input type="text" name="dni" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Email</label>
                                   <input type="text" name="email" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">Dirección</label>
                                   <input type="text" name="address" value="" class="form-control" required>
                              </div>
                         </div>
                         <div class="col-lg-4">
                              <div class="form-group">
                                   <label for="">foto</label>
                                   <input type="file" name="photo" id="photo" value="" class="form-control" required>
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
               </form>
          </div>
     </section>
     <?php if(isset($message)) echo $message;?>
</main>

<?php include('footer.php') ?>
