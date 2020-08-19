<?php
   require_once("Argentino.php");
   require_once("Ingles.php");
   require_once("Portugues.php");

    if($_POST)
    {
        $values=$_POST;
        $class= isset($values['language']) ? $values['language'] :"Argentino";
        $method= isset($values['action']) ? $values['action'] : "Greet";
        $parameter= array();

        if($method != "" && $method == 'other')
        {
            $val=isset($values['massage']) ? $values['massage'] : "";
            array_push($parameter,$val);

        }
        $instaceClass= new $class;

        if(!isset($parameter))
        {
            call_user_func(array($instaceClass,$method));
        }
        else
        {
            call_user_func_array(array($instaceClass,$method),$parameter);

        }
    }
    else
    {
        echo "Error al intentar procesar | <br> Regrese y vuelva a intentalo";
    }
?>
<br><br><br>
<p align="center"><a href="index.php">BACK TO HOME</a></p>