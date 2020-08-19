<?php
/* //este es para cuando el autoload esta dentro de la carpeta Config
define("ROOT", dirname(__DIR__) . "/");

spl_autoload_register(function($className)
{

    $fileName= ROOT . str_replace("\\" , "/" , $className) . ".php";
    
    echo "<br>" . $fileName;

    require_once($fileName);

});
*/

//este es para cuando el autoload esta suelto a la altura del index
spl_autoload_register(function($className)
{
    $fileName = $className . ".php";

    require_once($fileName);  
    echo "<br>" . $fileName;
});


?>