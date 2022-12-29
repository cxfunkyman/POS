<?php

class PrincipalModel extends Query {

    public function __construct()
    {
        parent::__construct();
    }
    public function verifyEmail($email)
    {
        $sql = "SELECT id FROM users WHERE email = '$email'";
        return $this->select($sql);
    }
    public function regToken($token, $email)
    {
        $sql = "UPDATE users SET token = ? WHERE email = ?";
        $arrData = array($token, $email);
        return $this->save($sql, $arrData);
    }
    public function verifyToken($token)
    {
        $sql = "SELECT id, token FROM users WHERE token = '$token'";
        return $this->select($sql);
    }
    public function verifyPassword($pass)
    {
        $sql = "SELECT id FROM users WHERE password = '$pass'";
        return $this->select($sql);
    }
    public function oldPass($token)
    {
        $sql = "SELECT password FROM users WHERE token = '$token'";
        return $this->select($sql);
    }
    public function updatePassword($password, $token)
    {
        $sql = "UPDATE users SET password = ? WHERE token = ?";
        $arrData = array($password, $token);
        return $this->save($sql, $arrData);
    }
    public function updateToken($password)
    {
        $sql = "UPDATE users SET token = ? WHERE password = ?";
        $arrData = array(NULL, $password);
        return $this->save($sql, $arrData);
    }
}