<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<hr>
    <div><label for="">MENU PRINCIPAL</label></div>
    <div>
    <label for="">CERVEZAS:</label><br>
        <input type="submit" value="Agregar Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> Beer/ShowAddBeerView'">
        <input type="submit" value="Eliminar Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> Beer/ShowDeleteBeerView'">
        <input type="submit" value="Modificar Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> Beer/ShowModifyBeerListView'">
        <input type="submit" value="Listar Cervezas" onclick="location='<?php echo FRONT_ROOT; ?> Beer/ShowListBeerView'">
    </div>
    <br>
    <div>
    <label for="">TIPOS DE CERVEZA:</label><br>
        <input type="submit" value="Agregar Tipo Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> BeerType/ShowAddBeerTypeView'">
        <input type="submit" value="Eliminar Tipo Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> BeerType/ShowDeleteBeerTypeView'">
        <input type="submit" value="Modificar Tipo Cerveza" onclick="location='<?php echo FRONT_ROOT; ?> BeerType/ShowModifyBeerTypeListView'">
        <input type="submit" value="Listar Tipos de Cervezas" onclick="location='<?php echo FRONT_ROOT; ?> BeerType/ShowListBeerTypeView'">
    </div>
    <div>
        <label for=""><?php if(isset($message))echo $message; ?></label>
    </div>
    <div>
        <a href="<?php echo FRONT_ROOT; ?>Logout/Index">Cerrar Sesion</a>
    </div>
    
</body>
</html>