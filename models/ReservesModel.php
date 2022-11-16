<?php

class ReservesModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getReserveList($idProduct)
    {
        $sql = "SELECT * FROM products WHERE id = $idProduct";
        return $this->select($sql);
    }
    public function regReserveOrder(
        $productData,
        $reserveDate,
        $withdrawDate,
        $depositAmount,
        $totalAmount,
        $color,
        $idClient,
        $idUser
    )
    {
        $sql = "INSERT INTO reserves (products, dates_reserves, dates_withdraw, payment, total, color, id_client, id_user) VALUES (?,?,?,?,?,?,?,?)";
        $arrData = array(
            $productData,
            $reserveDate,
            $withdrawDate,
            $depositAmount,
            $totalAmount,
            $color,
            $idClient,
            $idUser
        );
        return $this->insert($sql, $arrData);
    }
}
