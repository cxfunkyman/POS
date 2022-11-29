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
    public function getOpenClose()
    {
        $sql = "SELECT cr.*, u.first_name as name FROM cash_register cr INNER JOIN users u ON cr.id_user = u.id";
        return $this->selectAll($sql);
    }
    public function regExpenses($amount, $description, $photoDirectory, $idUser)
    {
        $sql = "INSERT INTO expenses (amount, description, photo, id_user) VALUES (?,?,?,?)";
        $arrData = array($amount, $description, $photoDirectory, $idUser);
        return $this->insert($sql, $arrData);
    }
}
