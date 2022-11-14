<?php

class CreditsModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getCredits()
    {
        $sql = "SELECT cr.*, cl.name FROM credits cr INNER JOIN sales sl ON cr.id_sale = sl.id INNER JOIN clients cl ON sl.id_client = cl.id";
        return $this->selectAll($sql);
    }
    public function getDeposits($idCredit)
    {
        $sql = "SELECT SUM(deposits) AS total FROM deposit WHERE id_credit = $idCredit";
        return $this->select($sql);
    }
    public function searchCreditData($value)
    {
        $sql = "SELECT cr.*, cl.name, cl.phone_number, cl.address FROM credits cr INNER JOIN sales sl ON cr.id_sale = sl.id INNER JOIN clients cl ON sl.id_client = cl.id WHERE cl.name LIKE '%" . $value . "%' AND cr.status = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
    public function regiterDeposit($idCredit, $depositAmount)
    {
        $sql = "INSERT INTO deposit(id_credit, deposits) VALUES(?,?)";
        $array = array($idCredit, $depositAmount);
        return $this->insert($sql, $array);
    }
    public function updateCredits($status, $idCredit)
    {
        $sql = "UPDATE credits SET status = ? WHERE id = ?";
        $array = array($status, $idCredit);
        return $this->save($sql, $array);
    }
    public function getAbonateCredits($idCredit)
    {
        $sql = "SELECT cr.*, sl.products, sl.serie, cl.identification, cl.num_identity, cl.name, cl.phone_number, cl.address FROM credits cr INNER JOIN sales sl ON cr.id_sale = sl.id INNER JOIN clients cl ON sl.id_client = cl.id WHERE cr.id = $idCredit";
        return $this->select($sql);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
    public function getAbonates($idCredit)
    {
        $sql = "SELECT * FROM deposit WHERE id_credit = $idCredit";
        return $this->selectAll($sql);
    }
}
