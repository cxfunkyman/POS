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
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    // income movement
    public function getCashSales($field, $idUser)
    {
        $sql = "SELECT SUM($field) AS total FROM sales WHERE pay_method = 'CASH' AND opening = 1 AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashReserves($idUser)
    {
        $sql = "SELECT SUM(dr.amount) AS total FROM detail_reserve dr INNER JOIN reserves r ON dr.id_reserves = r.id WHERE dr.opening = 1 AND dr.id_user = $idUser";
        return $this->select($sql);
    }
    public function getCashDeposits($idUser)
    {
        $sql = "SELECT SUM(deposits) AS total FROM deposit WHERE id_user = $idUser AND opening = 1";
        return $this->select($sql);
    }
    public function getCashCredits($idUser)
    {
        $sql = "SELECT SUM(amount) AS total FROM credits WHERE opening = 1 AND id_user = $idUser";
        return $this->select($sql);
    }
    //outcome movement
    public function getCashExpense($idUser)
    {
        $sql = "SELECT SUM(amount) AS total FROM expenses WHERE id_user = $idUser AND opening = 1";
        return $this->select($sql);
    }
    public function getCashPurchase($idUser)
    {
        $sql = "SELECT SUM(total) AS total FROM purchases WHERE id_user = $idUser AND opening = 1";
        return $this->select($sql);
    }
    public function getCRegisterSales($idUser)
    {
        $sql = "SELECT COUNT(*) AS total FROM sales WHERE id_user = $idUser AND opening = 1";
        return $this->select($sql);
    }
    public function cashRegisterClose($closeDate, $finalAmount, $totalSales, $outCome, $expenses, $idUser)
    {
        $sql = "UPDATE cash_register SET closing_date = ?, final_amount = ?, total_sale = ?, outcome = ?, expenses = ?, status = ? WHERE status = ? AND id_user = ?";
        $arrData = array($closeDate, $finalAmount, $totalSales, $outCome, $expenses, 0, 1, $idUser);
        return $this->save($sql, $arrData);
    }
    public function updateOpenCRegister($table, $idUser)
    {
        $sql = "UPDATE $table SET opening = ? WHERE id_user = ?";
        $arrData = array(0, $idUser);
        return $this->save($sql, $arrData);
    }
    public function getHistoryData($idCashRegister)
    {
        $sql = "SELECT * FROM cash_register WHERE id = $idCashRegister";
        return $this->select($sql);
    }
}
