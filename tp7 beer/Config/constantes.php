<?php 
namespace Config;

define('ROOT', str_replace('\\','/',dirname(__DIR__) . "/"));

//define('ROOT', str_replace('localhost/tpbecharge/'));

$base=explode($_SERVER['DOCUMENT_ROOT'],ROOT); 
//$_SERVER['DOCUMENT_ROOT'] : //C:/xampp/htdocs
//ROOT: C:/xampp/htdocs/tp final/
  define("BASE",$base[1]); //   /tp final 2/ 
  
  /*
  echo "server:" . $_SERVER['DOCUMENT_ROOT'];
  echo "<br> root: " . ROOT;
  echo "<br> constantes: " . $base[1];
  */
  
  define('HOST',"localhost");
  define('USER',"root");
  define('PASS',"");
  define('DB',"beerghost");



?>

