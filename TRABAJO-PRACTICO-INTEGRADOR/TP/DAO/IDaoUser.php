<?php
namespace Dao;

 use Model\User as user;

interface IDaoUser
{
    public function AddUser(User $user);
    public function GetAll();
    public function GetByEmail($userEmail);

}

?>