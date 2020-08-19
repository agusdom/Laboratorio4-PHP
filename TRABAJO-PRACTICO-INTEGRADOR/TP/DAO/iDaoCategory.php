<?php
namespace Dao;

use Model\Category as Category;

interface IDaoCategory
{
    function GetAll();
    public function AddCategory(Category $category);
    public function GetByCategoryId($categoryId);
    public function GetByCategoryName($name);
    public function ModifyCategory($id, Category $categoryNew);
    public function DeleteCategory($categoryName);

}

?>