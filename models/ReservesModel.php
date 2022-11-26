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
        $dateCreated,
        $timeCreated,
        $reserveDate,
        $withdrawDate,
        $depositAmount,
        $totalAmount,
        $totalReamaining,
        $color,
        $idClient,
        $idUser
    ) {
        $sql = "INSERT INTO reserves (products, dates, time_day, dates_reserves, dates_withdraw, payment, total, remaining, colors, id_client, id_user) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $arrData = array(
            $productData,
            $dateCreated,
            $timeCreated,
            $reserveDate,
            $withdrawDate,
            $depositAmount,
            $totalAmount,
            $totalReamaining,
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
    public function getDataReserves($idReserves)
    {
        $sql = "SELECT r.*, cl.identification, cl.num_identity, cl.name, cl.phone_number, cl.address FROM reserves r INNER JOIN clients cl ON r.id_client = cl.id WHERE r.id = $idReserves";
        return $this->select($sql);
    }
    public function setProcessDelivery($deposit, $remaining, $status, $idReserves)
    {
        $sql = "UPDATE reserves SET payment = ?, remaining = ?, status = ? WHERE id = ?";
        $array = array($deposit, $remaining, $status, $idReserves);
        return $this->save($sql, $array);
    }
    //Just to change the status of the reserve in the inventory
    public function updateInvMovement($movement, $currentDate, $currentTime, $lastMove)
    {
        $sql = "UPDATE inventory SET movement = ?, dates = ?, time_day = ? WHERE movement LIKE '%" . $lastMove . "%'";
        $array = array($movement, $currentDate, $currentTime);
        return $this->save($sql, $array);
    }
    public function cancelReserve($deposit, $remaining, $status, $idReserves)
    {
        $sql = "UPDATE reserves SET payment = ?, remaining = ?, status = ? WHERE id = ?";
        $array = array($deposit, $remaining, $status, $idReserves);
        return $this->save($sql, $array);
    }
    //For inventory movement
    public function registerInvMovement($movement, $actionReserve, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser)
    {
        $sql = "INSERT INTO inventory (movement, action, quantity, old_stock, actual_stock, dates, time_day, code, photo, id_product, id_user)
         VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $array = array($movement, $actionReserve, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $code, $photo, $idProduct, $idUser);
        return $this->insert($sql, $array);
    }
    public function updateQuantity($newQuantity, $idProduct)
    {
        $sql = "UPDATE products SET quantity = ? WHERE id = ?";
        $array = array($newQuantity, $idProduct);
        return $this->save($sql, $array);
    }
}
