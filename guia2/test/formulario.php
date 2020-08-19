<?php  

$keys = array_keys($_POST);

foreach ($keys as $key) {
	
	echo $key." : ".$_POST[$key]."<br>";
}

?>
<br><br><br>
<a href="index.html">Regresar al Formulario</a>