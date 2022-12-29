<?php

class ClientsModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getClients($status)
    {
        $sql = "SELECT * FROM clients WHERE status = '$status'";
        return $this->selectAll($sql);
    }
    public function regClient(
        $clientID,
        $clientIDNumb,
        $clientName,
        $clientPhone,
        $clientEmail,
        $clientAddress
    ) {
        $sql = "INSERT INTO clients (
            identification,
            num_identity,
            name,
            phone_number,
            email,
            address) VALUES (?,?,?,?,?,?)";

        $array = array(
            $clientID,
            $clientIDNumb,
            $clientName,
            $clientPhone,
            $clientEmail,
            $clientAddress
        );

        return $this->insert($sql, $array);
    }
    public function getClientValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM clients WHERE $field LIKE '%".$value."%'";
        } else {
            $sql = "SELECT id FROM clients WHERE $field LIKE '%".$value."%' AND id != $id";
        }
        return $this->select($sql);
    }
    public function eraseClient($status, $idClient)
    {
        $sql = "UPDATE clients SET status = ? WHERE id = ?";
        $array = array($status, $idClient);
        return $this->save($sql, $array);
    }
    public function updateClient($idClient)
    {
        $sql = "SELECT * FROM clients WHERE id = '$idClient'";
        return $this->select($sql);
    }
    public function modClient(
        $clientID,
        $clientIDNumb,
        $clientName,
        $clientPhone,
        $clientEmail,
        $clientAddress,
        $id
    ) {
        $sql = "UPDATE clients SET identification=?, num_identity=?, name=?, phone_number=?, email=?, address=? WHERE id=?";
        $array = array(
            $clientID,
            $clientIDNumb,
            $clientName,
            $clientPhone,
            $clientEmail,
            $clientAddress,
            $id
        );

        return $this->save($sql, $array);
    }
    public function getClientData($table)
    {
        $sql = "SELECT * FROM $table WHERE status = 1";
        return $this->selectAll($sql);
    }
    public function searchCData($value)
    {
        $sql = "SELECT id, name, phone_number, address FROM clients WHERE name LIKE '%".$value."%' AND status = 1 LIMIT 10";
        return $this->selectAll($sql);
    }
}
