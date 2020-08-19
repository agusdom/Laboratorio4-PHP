<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//define("FRONT_ROOT", "/UTN/MVC Example/");
define("FRONT_ROOT", "/tp7 beer/"); //aca va el nombre de la carpeta del proyecto encerrada entre
                                    // barras diagonales comunes
define("VIEWS_PATH", "Views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define("DB_HOST", "localhost");
define("DB_NAME", "pdo_example");
define("DB_USER", "root");
define("DB_PASS", "");