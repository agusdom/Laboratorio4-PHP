<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("Config/config.php");
require_once("Config/autoload.php");

use Config\autoload as autoload;
use Config\Request as Request;
use Config\Router as Router;

autoload::start();
session_start();

require_once(VIEWS_PATH . "header.php");
Router::Route(new Request());
require_once(VIEWS_PATH . "footer.php");


?>