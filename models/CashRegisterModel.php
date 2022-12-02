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
    public function getExpenseHistory()
    {
        $sql = "SELECT e.*, u.first_name as name FROM expenses e INNER JOIN users u ON e.id_user = u.id";
        return $this->selectAll($sql);
    }
    // income movement
    public function getCashReserves($idUser)
    {
        $sql = "SELECT SUM(payment) AS total FROM reserves WHERE id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashSales($idUser)
    {
        $sql = "SELECT SUM(total) AS total FROM sales WHERE pay_method = 'CASH' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashCredits($idUser)
    {
        $sql = "SELECT SUM(cr.amount) AS total FROM credits cr INNER JOIN sales sl ON cr.id_sale = sl.id AND sl.id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashDeposits($idUser)
    {
        $sql = "SELECT SUM(deposits) AS total FROM deposit WHERE id_user = $idUser";
        return $this->select($sql);
    }
    //outcome movement
    public function getCashPurchase($idUser)
    {
        $sql = "SELECT SUM(total) AS total FROM purchases WHERE id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashExpense($idUser)
    {
        $sql = "SELECT SUM(amount) AS total FROM expenses WHERE id_user = $idUser";
        return $this->select($sql);
    }
}
