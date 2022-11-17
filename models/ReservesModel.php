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
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getReserves($idReserves)
    {
        $sql = "SELECT r.*, cl.identification, cl.num_identity, cl.name, cl.phone_number, cl.address FROM reserves r INNER JOIN clients cl ON r.id_client = cl.id WHERE r.id = $idReserves";
        return $this->select($sql);
    }
    public function getCalendarReserves()
    {
        $sql = "SELECT r.*, cl.num_identity, cl.name FROM reserves r INNER JOIN clients cl ON r.id_client = cl.id";
        return $this->selectAll($sql);
    }
}
