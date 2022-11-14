<?php

class SalesModel extends Query {

    public function __construct()
    {
       parent::__construct();
    }
    public function getSaleList($idSale)
    {
        $sql = "SELECT * FROM products WHERE id = $idSale";
        return $this->select($sql);
    }
    public function regSaleOrder(
        $productData,
        $priceSubtotal,
        $totalPrice,
        $tps,
        $tvq,
        $currentDate,
        $currentTime,
        $payMethod,
        $discount,
        $discountAmount,
        $serie,
        $idClient,
        $idUser
    )
    {
        $sql = "INSERT INTO sales (products, subtotal, total, sale_tps, sale_tvq, dates, time_day, pay_method, discount, discount_amount, serie, id_client, id_user)
         VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $array = array(
            $productData,
            $priceSubtotal,
            $totalPrice,
            $tps,
            $tvq,
            $currentDate,
            $currentTime,
            $payMethod,
            $discount,
            $discountAmount,
            $serie,
            $idClient,
            $idUser
        );
        return $this->insert($sql, $array);
    }
    public function registerCredit($amountSale,  $currentDate, $currentTime, $idSale)
    {
        $sql = "INSERT INTO credits (amount, dates, time_date, id_sale) VALUES (?,?,?,?)";
        $array = array($amountSale,  $currentDate, $currentTime, $idSale);
        return $this->insert($sql, $array);
    }
    public function updateQuantity($newQuantity, $idProduct)
    {
        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $array = array($newQuantity, $idProduct);
        return $this->save($sql, $array);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getSales($idSales)
    {
        $sql = "SELECT s.*, c.identification, c.num_identity, c.name, c.phone_number, c.address
         FROM sales s INNER JOIN clients c ON s.id_client = c.id WHERE s.id = $idSales";
        return $this->select($sql);
    }
    public function getSerie()
    {
        $sql = "SELECT MAX(id) as serie FROM sales";
        return $this->select($sql);
    }
    public function listRecords()
    {
        $sql = "SELECT s.*, c.name FROM sales s INNER JOIN clients c ON s.id_client = c.id";
        return $this->selectAll($sql);
    }
    public function dropSaleOrder($idSale)
    {
        $sql = "UPDATE sales SET status = ? WHERE id = ?";
        $array = array(0, $idSale);
        return $this->save($sql, $array);
    }
    public function cancelCredit($idSale)
    {
        $sql = "UPDATE credits SET status = ? WHERE id_sale = ?";
        $array = array(2, $idSale);
        return $this->save($sql, $array);
    }


}
?>