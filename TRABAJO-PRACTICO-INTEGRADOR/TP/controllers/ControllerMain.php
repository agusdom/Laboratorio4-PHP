<?php
namespace Controllers;


class ControllerMain
{
    public function Index()
    {
        if(!isset($_SESSION["userLogged"]))
        {
            require_once("Views/viewLogin.php");
        }
    }

    public function LoadArtist()
    {
        require_once("Views/viewLoadArtist.php");
    }

    public function MainMenu()
    {
        require_once("Views/viewMain.php");
    }

    public function DeleteArtist()
    {
        $message="";
        require_once("Views/viewDeleteArtist.php");
    } 
}

?>