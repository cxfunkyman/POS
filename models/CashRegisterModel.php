<?php

class CashRegisterModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function openCashRegister($amount, $openDate, $idUser)
    {
        $sql = "INSERT INTO cash_register (initial_amount, opening_date, id_user) VALUES (?,?,?)";
        $arrData = array($amount, $openDate, $idUser);
        return $this->insert($sql, $arrData);
    }
    public function verifyIfOpen($idUser)
    {
        $sql = "SELECT * FROM cash_register WHERE status = 1 AND id_user = $idUser";
        return $this->select($sql);
    }
}
