<?php 
namespace Controllers;

class ControllerLogout
{
    public function Index()
    {
        session_destroy();
        require_once(VIEWS_PATH . "viewLogin.php");
    }
}

?>