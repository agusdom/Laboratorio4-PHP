<?php namespace Config;

define('ROOT', str_replace('\\','/',dirname(__DIR__) . "/"));

$base=explode($_SERVER['DOCUMENT_ROOT'],ROOT);
define("FRONT_ROOT", $base[1]);
// define("FRONT_ROOT", "/UTN/MVC Example/");
define("VIEWS_PATH", "views/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define("DB_HOST", "localhost");
define("DB_NAME", "beers");
define("DB_USER", "root");
define("DB_PASS", "");