<?php 
namespace Config;

define("ROOT", dirname(__DIR__). "/");

//revisar no esta bien hecho, no esta dado por el profe
spl_autoload_register(function($className)
{
    $fileName= ROOT . str_replace("\\", "/", $className) . ".php";
    echo $fileName . "<br>";
    require_once($fileName);
    
});

?>
