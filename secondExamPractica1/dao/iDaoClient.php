<?php
namespace Dao;

interface IDaoClient
{
    public function GetAll();
    public function GetByClientDni($clientDni);
    public function Delete($clientDni);
}

?>