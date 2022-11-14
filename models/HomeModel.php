<?php

class HomeModel extends Query
{
    public function __construct()
     {
        parent::__construct();    
     }
    public function getData($email)
    {        
        $sql = "SELECT id, first_name, email, `password` FROM users WHERE email = '$email'";
        return $this->select($sql);        
    }
}
?>