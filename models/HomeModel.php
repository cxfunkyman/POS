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
}
?>