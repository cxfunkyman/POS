<?php

class AdminModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getData()
    {
        $sql = "SELECT * FROM configuration";
        return $this->select($sql);
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
}
