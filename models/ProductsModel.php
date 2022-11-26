<?php

class ProductsModel extends Query
{
    public function __construct()
     {
        parent::__construct();
     }
    public function getProducts($status)
    {
        $sql = "SELECT p.*, m.measure, c.category FROM products p INNER JOIN measures m ON p.id_measure = m.id INNER JOIN categories c ON p.id_category = c.id WHERE p.status = '$status'";
        return $this->selectAll($sql);
    }
    public function regProduct(
        $pCode,
        $pDescription,
        $pPrice,
        $sPrice,
        $pMeasure,
        $pCategory,
        $pPhoto
        )
    {
        $sql = "INSERT INTO products (
        code,
        `description`,
        purchase_price,
        sale_price,
        id_measure,
        id_category,
        photo) VALUES (?,?,?,?,?,?,?)";

        $array = array(
            $pCode,
            $pDescription,
            $pPrice,
            $sPrice,
            $pMeasure,
            $pCategory,
            $pPhoto
        );
                
        return $this->insert($sql, $array);
    }
    public function getProductValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM products WHERE $field = '$value'";
        } else {
            $sql = "SELECT id FROM products WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }
    public function eraseProduct($status, $idProduct)
    {
        $sql = "UPDATE products SET status = ? WHERE id = ?";
        $array = array($status, $idProduct);
        return $this->save($sql, $array);
    }
    public function updateProduct($idProduct)
    {
        $sql = "SELECT * FROM products WHERE id = '$idProduct'";
        return $this->select($sql);
    }
    public function modProduct(
        $pCode,
        $pDescription,
        $pPrice,
        $sPrice,
        $pMeasure,
        $pCategory,
        $photoDirectory,
        $id
    )
    {
        $sql = "UPDATE products SET code=?, `description`=?, purchase_price=?, sale_price=?, id_measure=?, id_category=?, photo=? WHERE id=?";
        $array = array(
            $pCode,
            $pDescription,
            $pPrice,
            $sPrice,
            $pMeasure,
            $pCategory,
            $photoDirectory,
            $id
        );
                
        return $this->save($sql, $array);
    }
    public function getProductData($table)
    {
        $sql = "SELECT * FROM $table WHERE status = 1";
        return $this->selectAll($sql);
    }
    public function searchBarcode($value)
    {
        $sql = "SELECT id, description AS product, quantity FROM products WHERE code = '$value'";
        return $this->select($sql);
    }
    public function searchPName($value)
    {
        $sql = "SELECT id, description, quantity FROM products WHERE description LIKE '%".$value."%' AND status = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
}
