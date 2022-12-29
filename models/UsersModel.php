<?php

class UsersModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsers($status)
    {
        $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS name, email, phone_number, address, profile, rol FROM users WHERE status = $status";
        return $this->selectAll($sql);
    }
    public function signUpUsers(
        $fName,
        $lName,
        $email,
        $phone,
        $address,
        $profile,
        $password,
        $rol
    ) {
        $sql = "INSERT INTO users(first_name, last_name, email, phone_number, address, profile, password, rol) VALUES(?,?,?,?,?,?,?,?)";
        $array = array(
            $fName,
            $lName,
            $email,
            $phone,
            $address,
            $profile,
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
        $sql = "SELECT id, first_name, last_name, email, phone_number, address, profile, dates, rol FROM users WHERE id = $id";
        return $this->select($sql);
    }
    public function userProfile($id)
    {
        $sql = "SELECT * FROM users WHERE id = $id";
        return $this->select($sql);
    }
    public function userUpdate(
        $fName,
        $lName,
        $email,
        $phone,
        $address,
        $profile,
        $rol,
        $id
    ) {
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone_number=?, address=?, profile=?, rol=? WHERE id=?";
        $array = array(
            $fName,
            $lName,
            $email,
            $phone,
            $address,
            $profile,
            $rol,
            $id
        );
        return $this->save($sql, $array);
    }
    public function getprofileValidate($field, $value, $id)
    {
        $sql = "SELECT id FROM users WHERE NOT id = $id AND $field = '$value'";

        return $this->select($sql);
    }
    public function getpassValidate($field, $value, $id)
    {
        $sql = "SELECT id FROM users WHERE $field = '$value' AND id = $id";

        return $this->select($sql);
    }
    public function updateProfile(
        $id,
        $fName,
        $lName,
        $email,
        $phone,
        $address,
        $photoDirectory,
        $passHash
    ) {
        $sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone_number=?, address=?, profile=?, password=?  WHERE id=?";
        $array = array(
            $fName,
            $lName,
            $email,
            $phone,
            $address,
            $photoDirectory,
            $passHash,
            $id
        );
        return $this->save($sql, $array);
    }
    //Register access logout
    public function regAccess($event, $ip, $details, $idUser)
    {
        $sql = "INSERT INTO access(event, ip, details, id_user) VALUES(?, ?, ?, ?)";
        $arrData = array($event, $ip, $details, $idUser);
        return $this->insert($sql, $arrData);
    }
}
