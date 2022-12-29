<?php

class CategoriesModel extends Query
{
    public function __construct()
     {
        parent::__construct();
     }
    public function getCategories($status)
    {
        $sql = "SELECT * FROM categories WHERE `status` = '$status'";
        return $this->selectAll($sql);
    }
    public function regCategory($categoryName)
    {
        $sql = "INSERT INTO categories (category) VALUES (?)";
        $array = array($categoryName);
                
        return $this->insert($sql, $array);
    }
    public function getCategoryValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM categories WHERE $field = '$value'";
        } else {
            $sql = "SELECT id FROM categories WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }
    public function eraseCategory($status, $idCategory)
    {
        $sql = "UPDATE categories SET status = ? WHERE id = ?";
        $array = array($status, $idCategory);
        return $this->save($sql, $array);
    }
    public function updateCategory($idCategory)
    {
        $sql = "SELECT * FROM categories WHERE id = '$idCategory'";
        return $this->select($sql);
    }
    public function modCategory($categoryName, $id)
    {
        $sql = "UPDATE categories SET category=? WHERE id=?";
        $array = array($categoryName, $id);
                
        return $this->save($sql, $array);
    }
}
