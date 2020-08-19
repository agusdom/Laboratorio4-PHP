<?php 
namespace Controllers;

class ControllerLogout
{
    public function Index()
    {
        try
        {
            session_destroy();
            unset($_SESSION['userLogged']);
            unset($_SESSION["userBasket"]);
            require_once(VIEWS_PATH . "viewLogin.php");
        }
        catch(Exception $ex)
        {
            $eventList= $this->eventDao->GetAll();
            $message = 'Oops ! \n\n Hubo un problema al intentar mostrar la Pagina.\n Consulte a su Administrador o vuelva a intentarlo.';
            echo '<script type="text/javascript">confirm("'.$message.'");</script>';
            require_once(VIEWS_PATH."viewUserHome.php");
        } 
    }
}

?>