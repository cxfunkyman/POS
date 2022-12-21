<?php

class PurchasesModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getProductList($idProduct)
    {
        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
    }
    public function regProductOrder(
        $productData,
        $subTotalPrice,
        $totalPrice,
        $tps,
        $tvq,
        $currentDate,
        $currentTime,
        $purchaseNumber,
        $idSupplier,
        $idUser
    ) {
        $sql = "INSERT INTO purchases (products, subtotal, total, purchase_tps, purchase_tvq, dates, time_day, serie, id_supplier, id_user)
         VALUES (?,?,?,?,?,?,?,?,?,?)";
        $array = array(
            $productData,
            $subTotalPrice,
            $totalPrice,
            $tps,
            $tvq,
            $currentDate,
            $currentTime,
            $purchaseNumber,
            $idSupplier,
            $idUser
        );
        return $this->insert($sql, $array);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getPurchases($idPurchases)
    {
        $sql = "SELECT p.*, s.taxID, s.name, s.phone_number, s.address
         FROM purchases p INNER JOIN supplier s ON p.id_supplier = s.id WHERE p.id = $idPurchases";
        return $this->select($sql);
    }
    public function updateQuantity($newQuantity, $idProduct)
    {
        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $array = array($newQuantity, $idProduct);
        return $this->save($sql, $array);
    }
    public function listRecords()
    {
        $sql = "SELECT p.*, s.name FROM purchases p INNER JOIN supplier s ON p.id_supplier = s.id";
        return $this->selectAll($sql);
    }
    public function dropOrder($idPurchase)
    {
        $sql = "UPDATE purchases SET status = ? WHERE id = ?";
        $array = array(0, $idPurchase);
        return $this->save($sql, $array);
    }
    //For inventory movement
    public function registerInvMovement($movement, $actionPurchase, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser)
    {
        $sql = "INSERT INTO inventory (movement, action, quantity, old_stock, actual_stock, dates, time_day, code, photo, id_product, id_user)
         VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $array = array($movement, $actionPurchase, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser);
        return $this->insert($sql, $array);
    }

    // income movement
    public function getCashSales($field, $idUser)
    {
        $sql = "SELECT SUM($field) AS total FROM sales WHERE pay_method = 'CASH' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashReserves($idUser)
    {
        $sql = "SELECT SUM(payment) AS total FROM reserves WHERE id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashDeposits($idUser)
    {
        $sql = "SELECT SUM(deposits) AS total FROM deposit WHERE id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashCredits($idUser)
    {
        $sql = "SELECT SUM(cr.amount) AS total FROM credits cr INNER JOIN sales sl ON cr.id_sale = sl.id AND sl.id_user = $idUser";
        return $this->select($sql);
    }
    //outcome movement
    public function getCashExpense($idUser)
    {
        $sql = "SELECT SUM(amount) AS total FROM expenses WHERE id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashPurchase($idUser)
    {
        $sql = "SELECT SUM(total) AS total FROM purchases WHERE id_user = $idUser";
        return $this->select($sql);
    }
}
