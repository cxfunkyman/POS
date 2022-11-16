<?php

class QuotesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSaleList($idSale)
    {
        $sql = "SELECT * FROM products WHERE id = $idSale";
        return $this->select($sql);
    }
    public function regQuoteOrder(
        $productData,
        $priceSubtotal,
        $totalPrice,
        $tps,
        $tvq,
        $currentDate,
        $currentTime,
        $payMethod,
        $quoteValidate,
        $discount,
        $discountAmount,
        $idClient,
        $idUser
    )
    {
        $sql = "INSERT INTO quotes (products, subtotal, total, quote_tps, quote_tvq, dates, time_day, pay_method, validity, discount, discount_amount, id_client, id_user)
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
            $quoteValidate,
            $discount,
            $discountAmount,
            $idClient,
            $idUser
        );
        return $this->insert($sql, $array);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getQuotes($idQuotes)
    {
        $sql = "Select q.*, cl.identification, cl.num_identity, cl.name, cl.phone_number, cl.address FROM quotes q INNER JOIN clients cl ON q.id_client = cl.id WHERE q.id = $idQuotes";
        return $this->select($sql);
    }
    public function getRecordQuotes()
    {
        $sql = "Select q.*, cl.name FROM quotes q INNER JOIN clients cl ON q.id_client = cl.id";
        return $this->selectAll($sql);
    }
}
