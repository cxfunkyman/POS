<?php

class UsersModel extends Query
{
    public function __construct()
     {
        parent::__construct();
     }
    public function getUsers($status)
    {
        $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS name, email, phone_number, address, rol FROM users WHERE status = $status";
        return $this->selectAll($sql);        
    }
    public function signUpUsers( 
        $fName,
        $lName,
        $email,
        $phone,
        $address,
        $password,
        $rol
        )
    {
        $sql = "INSERT INTO users(first_name, last_name, email, phone_number, address, password, rol) VALUES(?,?,?,?,?,?,?)"; 
        $array = array(
            $fName,
            $lName,
            $email,
            $phone,
            $address,
            $password,
            $rol
        );
        return $this->insert($sql, $array);   
    }
    public function getValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id, email, phone_number FROM users WHERE $field = '$value'";
        } else {
            $sql = "SELECT id, email, phone_number FROM users WHERE $field = '$value' AND id != $id";
        } 
        return $this->select($sql);
    }
    public function delete($status, $id)
    {
        $sql = "UPDATE users SET `status` = ? WHERE id = ?";
        $array = array($status, $id);
        return $this->save($sql, $array);
    }
    public function userEdit($id)
    {
        $sql = "SELECT id, first_name, last_name, email, phone_number, address, rol FROM users WHERE id = $id";
        return $this->select($sql);
    }
    public function userUpdate( 
        $fName,
        $lName,
        $email,
        $phone,
        $address,
        $rol,
        $id
        )
    {
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone_number=?, address=?, rol=? WHERE id=?"; 
        $array = array(
            $fName,
            $lName,
            $email,
            $phone,
            $address,
            $rol,
            $id
        );
        return $this->save($sql, $array);   
    }
}
