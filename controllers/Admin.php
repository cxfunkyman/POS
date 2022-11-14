<?php

class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    // Use for graphic reports
    public function index()
    {
        $data['title'] = 'Admin Panel';
        $data['script'] = 'index.js'; // the script of the page is assigned to the array
        $this->views->getView('admin', 'home', $data);
    }
    // Company data
    public function configData()
    {
        $data['title'] = 'Company data';
        $data['script'] = 'configData.js'; // the script of the page is assigned to the array
        $data['company'] = $this->model->getData();
        $this->views->getView('admin', 'index', $data);
    }
    //Modify company data
    public function modifyCompany()
    {
        if (isset($_POST)) {
            $taxID = strClean($_POST['taxID']);
            $configName = strClean($_POST['configName']);
            $configPhone = strClean($_POST['configPhone']);
            $configEmail = strClean($_POST['configEmail']);
            $configAddress = strClean($_POST['configAddress']);
            $configMessage = strClean($_POST['configMessage']);
            $configTax = strClean($_POST['configTax']);
            $idCompany = strClean($_POST['idCompany']);

            if (empty($taxID)) {
                $res = array('msg' => 'TAX ID REQUIRED', 'type' => 'warning');
            } else if (empty($configName)) {
                $res = array('msg' => 'NAME REQUIRED', 'type' => 'warning');
            } else if (empty($configPhone)) {
                $res = array('msg' => 'PHONE NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($configEmail)) {
                $res = array('msg' => 'EMAIL REQUIRED', 'type' => 'warning');
            } else if (empty($configAddress)) {
                $res = array('msg' => 'ADDRESS REQUIRED', 'type' => 'warning');
            } else {
                $data = $this->model->updateCompany(
                    $taxID,
                    $configName,
                    $configPhone,
                    $configEmail,
                    $configAddress,
                    $configMessage,
                    $configTax,
                    $idCompany
                );
                if ($data > 0) {
                    $res = array('msg' => 'COMPANY UPDATED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR, COMPANY NOT UPDATED', 'type' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
