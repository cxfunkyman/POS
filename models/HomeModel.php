<?php

class HomeModel extends Query
{
    public function __construct()
     {
        parent::__construct();
     }
    public function getData($email)
    {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        return $this->select($sql);
    }
    //Register access login
    public function regAccess($event, $ip, $details, $idUser)
    {
        $sql = "INSERT INTO access(event, ip, details, id_user) VALUES(?, ?, ?, ?)";
        $arrData = array($event, $ip, $details, $idUser);
        return $this->insert($sql, $arrData);
    }
}
?>