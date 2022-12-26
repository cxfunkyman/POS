<?php

class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getData()
    {
    }
    public function updateCompany(
        $taxID,
        $configName,
        $configPhone,
        $configEmail,
        $configAddress,
        $configMessage,
        $configTax,
        $idCompany
    ) {
        $sql = "UPDATE configuration SET taxID=?, name=?, phone_number=?, email=?, address=?, message=?, tax=? WHERE id=?";
        $array = array(
            $taxID,
            $configName,
            $configPhone,
            $configEmail,
            $configAddress,
            $configMessage,
            $configTax,
            $idCompany
        );
        return $this->save($sql, $array);
    }
    public function getTotalData($table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE status = 1";
        return $this->select($sql);
    }
    public function getTotalSumData($dateFrom, $dateTo, $column, $table, $method, $idUser)
    {
        $sql = "SELECT SUM($column) AS total FROM $table WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND pay_method = '$method' AND status = 1 AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getTotalSum($dateFrom, $dateTo, $column, $table, $idUser)
    {
        $sql = "SELECT SUM($column) AS total FROM $table WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND status = 1 AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getTotalExpense($dateFrom, $dateTo, $column, $table, $idUser)
    {
        $sql = "SELECT SUM($column) AS total FROM $table WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function monthlySales($dateFrom, $dateTo, $method, $idUser)
    {
        $sql = "SELECT SUM(IF(MONTH(dates) = 1, subtotal, 0)) as jan,
        SUM(IF(MONTH(dates) = 2, subtotal, 0)) as feb,
        SUM(IF(MONTH(dates) = 3, subtotal, 0)) as mar,
        SUM(IF(MONTH(dates) = 4, subtotal, 0)) as apr,
        SUM(IF(MONTH(dates) = 5, subtotal, 0)) as may,
        SUM(IF(MONTH(dates) = 6, subtotal, 0)) as jun,
        SUM(IF(MONTH(dates) = 7, subtotal, 0)) as jul,
        SUM(IF(MONTH(dates) = 8, subtotal, 0)) as aug,
        SUM(IF(MONTH(dates) = 9, subtotal, 0)) as sep,
        SUM(IF(MONTH(dates) = 10, subtotal, 0)) as oct,
        SUM(IF(MONTH(dates) = 11, subtotal, 0)) as nov,
        SUM(IF(MONTH(dates) = 12, subtotal, 0)) as dic
        FROM sales WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND pay_method = '$method' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function monthlyDiscount($dateFrom, $dateTo, $method, $idUser)
    {
        $sql = "SELECT SUM(IF(MONTH(dates) = 1, discount_amount, 0)) as jan,
        SUM(IF(MONTH(dates) = 2, discount_amount, 0)) as feb,
        SUM(IF(MONTH(dates) = 3, discount_amount, 0)) as mar,
        SUM(IF(MONTH(dates) = 4, discount_amount, 0)) as apr,
        SUM(IF(MONTH(dates) = 5, discount_amount, 0)) as may,
        SUM(IF(MONTH(dates) = 6, discount_amount, 0)) as jun,
        SUM(IF(MONTH(dates) = 7, discount_amount, 0)) as jul,
        SUM(IF(MONTH(dates) = 8, discount_amount, 0)) as aug,
        SUM(IF(MONTH(dates) = 9, discount_amount, 0)) as sep,
        SUM(IF(MONTH(dates) = 10, discount_amount, 0)) as oct,
        SUM(IF(MONTH(dates) = 11, discount_amount, 0)) as nov,
        SUM(IF(MONTH(dates) = 12, discount_amount, 0)) as dic
        FROM sales WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND pay_method = '$method' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function monthlyPurchases($dateFrom, $dateTo, $idUser)
    {
        $sql = "SELECT SUM(IF(MONTH(dates) = 1, subtotal, 0)) as jan,
        SUM(IF(MONTH(dates) = 2, subtotal, 0)) as feb,
        SUM(IF(MONTH(dates) = 3, subtotal, 0)) as mar,
        SUM(IF(MONTH(dates) = 4, subtotal, 0)) as apr,
        SUM(IF(MONTH(dates) = 5, subtotal, 0)) as may,
        SUM(IF(MONTH(dates) = 6, subtotal, 0)) as jun,
        SUM(IF(MONTH(dates) = 7, subtotal, 0)) as jul,
        SUM(IF(MONTH(dates) = 8, subtotal, 0)) as aug,
        SUM(IF(MONTH(dates) = 9, subtotal, 0)) as sep,
        SUM(IF(MONTH(dates) = 10, subtotal, 0)) as oct,
        SUM(IF(MONTH(dates) = 11, subtotal, 0)) as nov,
        SUM(IF(MONTH(dates) = 12, subtotal, 0)) as dic
        FROM purchases WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function topProducts($qty)
    {
        $sql = "SELECT p.*, c.category FROM products p INNER JOIN categories c ON p.id_category = c.id ORDER BY sales DESC LIMIT $qty";
        return $this->selectAll($sql);
    }
    public function newProducts($qty)
    {
        $sql = "SELECT p.*, c.category FROM products p INNER JOIN categories c ON p.id_category = c.id ORDER BY id DESC LIMIT $qty";
        return $this->selectAll($sql);
    }
    public function monthlyExpenses($dateFrom, $dateTo, $idUser)
    {
        $sql = "SELECT SUM(IF(MONTH(dates) = 1, amount, 0)) as jan,
        SUM(IF(MONTH(dates) = 2, amount, 0)) as feb,
        SUM(IF(MONTH(dates) = 3, amount, 0)) as mar,
        SUM(IF(MONTH(dates) = 4, amount, 0)) as apr,
        SUM(IF(MONTH(dates) = 5, amount, 0)) as may,
        SUM(IF(MONTH(dates) = 6, amount, 0)) as jun,
        SUM(IF(MONTH(dates) = 7, amount, 0)) as jul,
        SUM(IF(MONTH(dates) = 8, amount, 0)) as aug,
        SUM(IF(MONTH(dates) = 9, amount, 0)) as sep,
        SUM(IF(MONTH(dates) = 10, amount, 0)) as oct,
        SUM(IF(MONTH(dates) = 11, amount, 0)) as nov,
        SUM(IF(MONTH(dates) = 12, amount, 0)) as dic
        FROM expenses WHERE dates BETWEEN '$dateFrom' AND '$dateTo' AND id_user = $idUser";
        return $this->select($sql);
    }
    public function stockMinimum($qty)
    {
        $sql = "SELECT p.*, c.category FROM products p INNER JOIN categories c ON p.id_category = c.id ORDER BY quantity ASC LIMIT $qty";
        return $this->selectAll($sql);
    }
    public function countReserves($from, $to, $status, $idUser)
    {
        $sql = "SELECT COUNT(*) AS total FROM reserves WHERE dates BETWEEN '$from' AND '$to' AND status = $status AND id_user = $idUser";
        return $this->select($sql);
    }
    public function getCompanies()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
    }

}
