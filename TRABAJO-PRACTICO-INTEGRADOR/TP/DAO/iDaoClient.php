<?php
namespace DAO;

use Model\Client as Client;

interface iDaoClient{

    public function AddClient(Client $client);
    public function GetAll();
    public function ModifyClient($dni,Client $newClient);
    public function DeleteClient($dni);
    public function GetByClientDni($dni);

}
?>