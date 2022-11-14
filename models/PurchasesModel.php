<?php

class PurchasesModel extends Query {

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
    )
    {
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
}



?>