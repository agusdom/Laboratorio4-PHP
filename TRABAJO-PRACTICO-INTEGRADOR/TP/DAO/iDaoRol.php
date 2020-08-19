<?php
namespace Dao;

use Model\Rol as Rol;

interface IDaoRol
{
    function GetAll();
    public function Add(Rol $Rol);
    public function GetById($RolId);
    public function Modify($id, Rol $RolNew);
    public function Delete($RolName);

}

?>