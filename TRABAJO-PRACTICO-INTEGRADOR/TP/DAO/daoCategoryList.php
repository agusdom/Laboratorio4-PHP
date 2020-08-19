<?php
namespace Dao;

use Dao\IDaoCategory as IDaoCategory;
use Model\Category as Category;

class DaoCategorylist implements IDaoCategory
{
    private $categorylist;

    public function __construct()
    {
        if(!isset($_SESSION["categorylist"]))
        {
            $_SESSION["categorylist"]= array();
        }
        $this->categorylist= &$_SESSION["categorylist"];
    }

    function GetAll()
    {
        return $this->categorylist;
    }

    public function AddCategory(Category $category)
    {
        $id= 0;
        if(!isset($_SESSION["categoryId"]))
        {
            $id= 1;
            $_SESSION["categoryId"]= $id;
        }
        else
        {
            $id= $_SESSION["categoryId"];
            $id++;
            $_SESSION["categoryId"]= $id;
        }
        echo "el id es: " . $id;
        $category->setId($id);

        array_push($this->categorylist, $category);
    }

    public function GetByCategoryId($categoryId)
    {
    //busca un objeto en el repositorio por el id 
    //devuelve el objeto si lo encuentra, sino devuelve null
        
        $object= null;

        foreach($this->categorylist as $category)
        {
            if($category->getId() == $categoryId)
            {
                $object= $category;
                break;
            }
        }
        return $object;
    }


    public function ModifyCategory($id, Category $categoryNew)
    {
        $index= 0;

        foreach($this->categorylist as $category)
        {
            if($category->getId() == $id)
            {
                array_splice($this->categorylist, $index, 1, array($categoryNew));
            }
            $index++;
        }
    }

    public function DeleteCategory($categoryId)
    {
        $i= 0;

        foreach($this->categorylist as $category)
        {
            if($category->getId() == $categoryId)
            {
                unset($this->categorylist[$i]);
                break;
            }
            $i++;
        }
        $this->categorylist= array_values($this->categorylist);
    }
}

?>