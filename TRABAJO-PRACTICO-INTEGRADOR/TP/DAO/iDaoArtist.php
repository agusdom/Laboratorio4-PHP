<?php
namespace Dao;

 use Model\Artist as Artist;

interface IDaoArtist
{
    public function AddArtist(Artist $artist);
    public function GetAll();
    public function GetByArtistId($artistId);
    public function GetByArtisticName($artisticName);
    public function DeleteArtist($artistId);
    public function ModifyArtist($id, Artist $newArtist);

}

?>