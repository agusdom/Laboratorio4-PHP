<?php include_once("header.php"); ?>
<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>2º Parcial - Laboratorio IV</h2>
            <p>Rimoldi Nicolas</p>
        </header>
        <form action="<?php echo FRONT_ROOT. 'Login/Login' ?>" method="post" class="login-form bg-dark-alpha p-5 text-white">
            <div class="form-group">
                    <label for="">Usuario</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Ingresar usuario">
            </div>
            <div class="form-group">
                    <label for="">Contraseña</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
            </div>
            <button class="btn btn-dark btn-block btn-lg" type="submit">
                    Iniciar Sesión
            </button>
        </form>
    </div>
</main>
<label for=""><?php if(isset($message)) echo $message;?></label>

<?php include_once("footer.php"); ?>
