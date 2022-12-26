<?php

class InventoryModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getInvMovement()
    {
        $sql = "SELECT i.*, p.description AS product, p.quantity AS stock, u.first_name AS name, u.last_name AS lname FROM inventory i
        INNER JOIN products p ON i.id_product = p.id INNER JOIN users u ON i.id_user = u.id";
        return $this->selectAll($sql);
    }
    public function getMoveByMonth($year, $month)
    {
        $sql = "SELECT i.*, p.description AS product, p.quantity AS stock, u.first_name AS name, u.last_name AS lname FROM inventory i
        INNER JOIN products p ON i.id_product = p.id INNER JOIN users u ON i.id_user = u.id
        WHERE YEAR(i.dates) = $year AND MONTH(i.dates) = $month";
        return $this->selectAll($sql);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getProduct($idProduct)
    {
        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
    }
    public function regAdjustment($idProduct, $newQuantity, $idUser)
    {
        $sql = "UPDATE products SET quantity = ?, update_user_id = ? WHERE id = ?";
        $array = array($newQuantity, $idUser, $idProduct);
        return $this->save($sql, $array);
    }
    //For inventory movement
    public function registerInvMovement($movement, $actionInventory, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser)
    {
        $sql = "INSERT INTO inventory (movement, action, quantity, old_stock, actual_stock, dates, time_day, code, photo, id_product, id_user)
         VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $array = array($movement, $actionInventory, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser);
        return $this->insert($sql, $array);
    }
    public function getKardex($idProduct)
    {
        $sql = "SELECT i.*, p.description AS product, u.first_name AS name, u.last_name AS lname FROM inventory i
        INNER JOIN products p ON i.id_product = p.id INNER JOIN users u ON i.id_user = u.id
        WHERE i.id_product = $idProduct";
        return $this->selectAll($sql);
    }
    public function invProductVerify($idProduct)
    {
        $sql = "SELECT id FROM inventory WHERE id_product = $idProduct LIMIT 1";
        return $this->select($sql);
    }
}
