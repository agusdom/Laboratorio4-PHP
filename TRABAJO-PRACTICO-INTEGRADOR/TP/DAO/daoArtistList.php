<?php
namespace Dao;

use Model\Artist as Artist;
use Dao\IDaoArtist as IDaoArtist;

class DaoArtistList implements IDaoArtist
{
    private $artistList;
    
    
    public function __construct()
    {
       if(!isset($_SESSION["artistList"]))
       {
            $_SESSION["artistList"]= array(); 
       }
       $this->artistList= &$_SESSION["artistList"];
    }

    public function AddArtist(Artist $artist)
    {
        $id=0;
        if(!isset($_SESSION["artistId"]))
        {
            $id=1;
            $_SESSION["artistId"]= $id;
        }
        else
        {
            $id= $_SESSION["artistId"];
            $id++;
            $_SESSION["artistId"]= $id;
        }
        $artist->setId($id);
        array_push($this->artistList, $artist);
    }

    public function GetAll()
    {
        return $this->artistList;
    }

    public function GetByArtistId($artistId)
    {
        $object= null;

        foreach($this->artistList as $artist)
        {
            if($artist->getId() == $artistId)
            {
                $object= $artist;
                break;
            }
        }
        return $object;
    }

    public function DeleteArtist($artistId)
    {
        $i=0;

        foreach($this->artistList as $artist)
        {
            if($artist->getId() == $artistId)
            {
                unset($this->artistList[$i]);
                break;
            }
            $i++;
        }
        $this->artistList= array_values($this->artistList);
    }

    public function ModifyArtist($id, artist $artistNew)
    {
        $index=0;
        
        foreach($this->artistList as $artist)
        {
            if($artist->getId() == $id)
            {
                array_splice($this->artistList, $index, 1, array($artistNew)); 
            }
            $index++;
        }
    }   

   
    
}
?>