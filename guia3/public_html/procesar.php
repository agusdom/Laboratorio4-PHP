<?php  
require_once("items.php");
$noPost=false;

 if($_POST){
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "Nombre no cargado";
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "Apellido no cargado";
        $dni = isset($_POST["DNI"]) ? $_POST["DNI"] : "DNI no cargado";
        $email = isset($_POST["email"]) ? $_POST["email"] : "Email no cargado";
        $fecha = isset($_POST["fecha"]) ? $_POST["fecha"] : "Fecha no cargada";
        $nroFactura = isset($_POST["nroFactura"]) ? $_POST["nroFactura"] : "Numero de factura no cargada";
        $tipoFactura = isset($_POST["tipoFactura"]) ? $_POST["tipoFactura"] : "Tipo de factura no cargada";
        $subtotal = 0;
        $total = 0;        

        $itemArray = array();
        $cantidadItems = 0;

        for($i=1; $i < 6 ; $i++){ //cargar items en el arreglo
            if($_POST["detalle$i"] != null){ //isset no funciona
                $cantidadItems++;
                $item = new Item($_POST["detalle$i"], $_POST["cant$i"], $_POST["precio$i"]); //creacion de item a base de index
                $subtotal += $item->calcularPrecioTotal();  //llamado al metodo dentro de item para calcular el descuento
            
                array_push($itemArray, $item);  //inserciÃ³n al final de array
            }
        }
        
        if($tipoFactura=="a") $total = $subtotal + $subtotal * 9 / 100; //descuento dependiendo del tipo de factura seleccionado
        else if($tipoFactura=="b") $total = $subtotal + $subtotal * 21 / 100;

        //var_dump($itemArray);
    }
    else{
        echo "<h1>No hay post</h1>";
        $noPost = true; //variable para esconder todo el html en caso de que no halla post
    } 
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>GuÃ­a 4 - Resultado</title>
        <style  type="text/css">
            *{
                text-align: center;
                box-sizing: border-box;
            }
            .wrapper{
                width: 800px;
                margin: 0 auto;
                border: 1px;
                border-style: solid;
            }
            #top{
                border: 1px;
                border-style: solid;
                margin: 5px;
            }
            #bottom{
                border: 1px;
                border-style: solid;
                margin: 5px;
            }
            #tabla-items{
                width: 95%;
                margin: 15px auto;
                border: 3px;
                border-style: solid;
            }
            #tabla-totales{
                /*width: 95%;*/ /*conflicto con grosor de celdas (td width)*/
                margin: 15px auto;
                border: 5px;
                border-style: solid;
                border-color: gray;
            }
            td{
                border: 1px;
                border-style: solid;
            }
            #resumen-factura{
                border-radius: 3px;
                font-size: 20px;
                margin: auto;
                width: 160px;
                background-color: green;
                color: white;
                font-weight: bold;
            }
            .totales{
                font-weight: bold;
                font-size: 16px;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="wrapper" <?php if($noPost) echo "hidden"?>> <!--esconde todo el html en caso de no haber post -->
            <section id="top">
                <div id="resumen-factura"><p>Resumen Factura</p></div>
                <label for="nombre">Nombre: </label><input type="text" name="nombre" value="<?= $nombre ?>" readonly /> 
                <label for="apellido">Apellido: </label><input type="text" name="apellido" value="<?= $apellido ?>" readonly /><br><br>
                <label for="DNI">DNI: </label><input type="number" name="DNI" value="<?= $dni ?>" /> 
                <label for="email">Email: </label><input type="email" name="email" value="<?= $email ?>" readonly /><br>
                <hr>
                <label for="fecha">Fecha: </label><input type="date" name="fecha" value="<?= $fecha ?>" readonly /> 
                <label for="nroFactura">Numero Factura: </label><input type="number" value="<?= $nroFactura ?>" readonly /><br><br>
                <input type="radio" name="tipoFactura" value="a" readonly <?php echo ($tipoFactura=="a") ? "checked" : "disabled"; ?> /> Factura A 
                <input type="radio" name="tipoFactura" value="b" readonly <?php echo ($tipoFactura=="b") ? "checked" : "disabled"; ?>/> Factura B
                <br><br>
            </section>
            <section id="bottom">
                <table id="tabla-items">
                    <tr style="font-size: 17px;">
                        <th>Detalles</th>
                        <th>Cantidades</th>
                        <th>Precios</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php 
                        for($i=0 ; $i<count($itemArray) ; $i++){ //crea lineas de tabla dependiendo del largo del array de items usando echo
                            ?><tr>								 <!--switch a html cerrando php dentro del for y abiendolo antes de que termine-->
                                  <td><input type='text' value="<?= $itemArray[$i]->getDetalle()?>" readonly /></td>
                                  <td><input type='text' value="<?= $itemArray[$i]->getCantidad()?>" readonly /></td>
                                  <td><input type='text' value="<?= $itemArray[$i]->getPrecio()?>" readonly /></td>
                                  <td><input type='text' value="<?= $itemArray[$i]->calcularPrecioTotal()?>" readonly /></td>
                              </tr>
							<?php 
                        }
                    ?>
                </table>
                <table id="tabla-totales">
                    <tr>
                        <td style="width:510px;"><input type="text" value="SUBTOTAL" class="totales" readonly/></td>
                        <td style="width:50px;"><input type="text" value="<?= $subtotal ?>" class="totales" readonly/></td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;"><input type="text" value="TOTAL" class="totales" style="background-color: gray;" readonly /></td>
                        <td><input type="text" value="<?= $total ?>" class="totales" readonly /></td>
                    </tr>
                </table>
            </section>
        </div>
    </body>
</html>



