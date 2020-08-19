<?php
    require_once("functions.php");
    require_once("Vehicle.php");

    //call_user_func()
    /*
    $functionName = "Sum";
    $parameter1 = 8;
    $parameter2 = 10;
    $functionName2 = "DoSomething";

    echo call_user_func("$functionName", $parameter1, $parameter2); 
    echo "<br>";
    echo call_user_func("$functionName2");
    */

    /*
    $functionName = $_GET["functionName"];
    $parameter1 = $_GET["parameter1"];

    $parameter2 = isset($_GET["parameter2"]) ? $_GET["parameter2"] : "";

    echo call_user_func($functionName, $parameter1, $parameter2);
    */

    $vehicle =  new Vehicle(); //call_user_func de un metodo
    $method = "SetPilots";
    $speed = 80;
    $pilot = "Juan";
    $copilot = "Sebas";

    echo call_user_func(array($vehicle, $method), $speed); //se envia un arreglo con objeto, metodo como primer parametro
    echo call_user_func_array(array($vehicle, $method), array($pilot, $copilot));
?>