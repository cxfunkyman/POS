<?php

class InventoryModel extends Query
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getInvMovement()
    {
        $sql = "SELECT i.*, p.description AS product, u.first_name AS name FROM inventory i
        INNER JOIN products p ON i.id_product = p.id INNER JOIN users u ON i.id_user = u.id";
        return $this->selectAll($sql);
    }
    public function getMoveByMonth($year, $month)
    {
        $sql = "SELECT i.*, p.description AS product, u.first_name AS name FROM inventory i
        INNER JOIN products p ON i.id_product = p.id INNER JOIN users u ON i.id_user = u.id
        WHERE YEAR(i.dates) = $year AND MONTH(i.dates) = $month";
        return $this->selectAll($sql);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }
}