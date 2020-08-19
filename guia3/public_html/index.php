<?php  

?>
<html>
    <head>
        <meta charset="utf-8">
        <title>GuÃ­a 4</title>
        <style>
            *{
                text-align: center;
                /*width: 100%*/
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
                margin: 15px auto;
                border: 3px;
                border-style: solid;
            }
            td{
                border: 1px;
                border-style: solid;
            }
            #detalle-factura{
                border-radius: 3px;
                font-size: 20px;
                margin: auto;
                width: 150px;
                background-color: green;
                color: white;
                font-weight: bold;
            }
            #cabecera-factura{
                border-radius: 3px;
                font-size: 20px;
                margin: auto;
                width: 160px;
                background-color: #8B4B9B;
                color: white;
                font-weight: bold;
            }
        </style>
 <head>
        <title>Guia 3</title>
       
    <html>
    <head>
        <title>Guia 3</title>
       
    </head>
    <body>
        <div class="wrapper" >
            <form action="procear.php" method="POST" id="form1">
                <section id="top">
                    <div id="cabecera-factura"><p>Cabecera Factura</p></div>
                     <label for="nombre">Nombre: </label><input type="text" name="nombre" required /> 
                     <label for="nombre">Apellido: </label><input type="text" name="apellido" required /> <br></br>
                     <label for="nombre">Dni: </label><input type="text" name="dni" required /> 
                     <label for="nombre">Email: </label><input type="text" name="email" required /><br>
                     <hr>
                     <label for="Fecha">Nombre: </label><input type="date" name="fecha" required /> 
                     <label for="nombre">Numero Factura: </label><input type="number" name="nfactura" required /> <br></br>
                     <input type="radio" name="Tipofactura" value="A" checked> Factura A
                      <input type="radio" name="Tipofactura" value="B" checked> Factura B
                      <br></br>
                </section>
                <section id="botton">
                    <div id="Detalle-facura"><p>Detalle Factura</p></div>
                    <div id="Tabla-items">
                 <?php  
for($a; $a<6; $a++)
{
?> 
<tr>
<td>
 <label for="detalle<?=$a>">Detalle: </label><input type="text" name="detalle<?=$a>"<?php if($a==1) echo "required";?> />
 <label for="cantidad<?=$a>">Cantidad: </label><input type="number" name="cantidad<?=$a>"<?php if($a==1) echo "required";?> />
 <label for="precio<?=$a>">Precio: </label><input type="number" name="precio<?=$a>"<?php if($a==1) echo "required";?> />
</td>
</tr>
<php
}
?>
</table>
<imput type="submit" value="Procesar"/>
<imput type="submit" value="Restablecer"/>
<br></br>
</section>
</form>
</div>
</body>
</html>
