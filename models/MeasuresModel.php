<?php

class MeasuresModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMeasures($status)
    {
        $sql = "SELECT * FROM measures WHERE `status` = $status";
        return $this->selectAll($sql);
    }
    public function regMeasures($measureName, $shortName)
    {
        $sql = "INSERT INTO measures (measure, short_name) VALUES (?,?)";
        $array = array($measureName, $shortName);
                
        return $this->insert($sql, $array);
    }
    public function getMeasureValidate($field, $value, $action, $id)
    {
        if ($action == 'register' && $id == 0) {
            $sql = "SELECT id FROM measures WHERE $field = '$value'";
        } else {
            $sql = "SELECT id FROM measures WHERE $field = '$value' AND id != $id";
        }
        return $this->select($sql);
    }
    public function eraseMeasure($status, $idMeasure)
    {
        $sql = "UPDATE measures SET status = ? WHERE id = ?";
        $array = array($status, $idMeasure);
        return $this->save($sql, $array);
    }
    public function updateMeasure($idMeasure)
    {
        $sql = "SELECT * FROM measures WHERE id = '$idMeasure'";
        return $this->select($sql);
    }
    public function modMeasure($measureName, $shortName, $id)
    {
        $sql = "UPDATE measures SET measure=?, short_name=? WHERE id=?";
        $array = array($measureName, $shortName, $id);
                
        return $this->save($sql, $array);
    }
}
