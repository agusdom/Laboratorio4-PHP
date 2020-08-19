<?php namespace Config;

define("ROOT", dirname(__DIR__) . "/");
//define("FRONT_ROOT", "/UTN/MVC Example/");
define("FRONT_ROOT", "/tpfinal/"); //aca va el nombre de la carpeta del proyecto encerrada entre
                                    // barras diagonales comunes
define("VIEWS_PATH", "Views/");
define("QR_PATH", "phpqrcode/");
define("PDF_PATH", "fpdf/");
define("EMAIL_PATH", "PHPMailer/");
define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");

define("DB_HOST", "localhost");
define("DB_NAME", "tp_final");
define("DB_USER", "root");
define("DB_PASS", "");