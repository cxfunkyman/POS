<?php

class SuppliersModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getSuppliers($status)
    {
        $sql = "SELECT * FROM supplier WHERE status = '$status'";
        return $this->selectAll($sql);
    }
    public function regSupplier(
        $sTaxID,
        $sName,
        $sPhone,
        $sEmail,
        $sAddress
    ) {
        $sql = "INSERT INTO supplier (
            taxID,
            name,
            phone_number,
            email,
            address) VALUES (?,?,?,?,?)";

        $array = array(
            $sTaxID,
            $sName,
            $sPhone,
            $sEmail,
            $sAddress
        );

        return $this->insert($sql, $array);
    }
    public function getSupplierValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM supplier WHERE $field LIKE '%$value%'";
        } else {
            $sql = "SELECT id FROM supplier WHERE $field LIKE '%$value%' AND id != $id";
        }
        return $this->select($sql);
    }
    public function eraseSupplier($status, $idSupplier)
    {
        $sql = "UPDATE supplier SET status = ? WHERE id = ?";
        $array = array($status, $idSupplier);
        return $this->save($sql, $array);
    }
    public function updateSupplier($idSupplier)
    {
        $sql = "SELECT * FROM supplier WHERE id = '$idSupplier'";
        return $this->select($sql);
    }
    public function modSupplier(
        $sTaxID,
        $sName,
        $sPhone,
        $sEmail,
        $sAddress,
        $id
    ) {
        $sql = "UPDATE supplier SET taxID=?, name=?, phone_number=?, email=?, address=? WHERE id=?";
        $array = array(
            $sTaxID,
            $sName,
            $sPhone,
            $sEmail,
            $sAddress,
            $id
        );

        return $this->save($sql, $array);
    }
    public function getSupplierData($table)
    {
        $sql = "SELECT * FROM $table WHERE status = 1";
        return $this->selectAll($sql);
    }
    public function searchSData($value)
    {
        $sql = "SELECT id, name, phone_number, address FROM supplier WHERE name LIKE '%" . $value . "%' AND status = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
    public function validateOrderNumber($serialNumber)
    {
        $sql = "SELECT id FROM purchases WHERE serie LIKE '%" . $serialNumber . "%'";
        return $this->select($sql);
    }
}
