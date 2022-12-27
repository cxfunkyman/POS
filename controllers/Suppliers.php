<?php

class Suppliers extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'Suppliers';
        $data['script'] = 'supplier.js'; // the script of the page is assigned to the array
        $this->views->getView('suppliers', 'index', $data);
    }
    public function listSuppliers()
    {
        $data = $this->model->getSuppliers(1);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteSupplier(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editSupplier(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerSuppliers()
    {
        if (isset($_POST['supplierTaxID']) && isset($_POST['supplierName'])) {
            $id = strClean($_POST['idSupplier']);
            $supplierTaxID = strClean($_POST['supplierTaxID']);
            $supplierName = strClean($_POST['supplierName']);
            $supplierPhone = strClean($_POST['supplierPhone']);
            $supplierEmail = strClean($_POST['supplierEmail']);
            $supplierAddress = strClean($_POST['supplierAddress']);

            if (empty($supplierTaxID)) {
                $res = array('msg' => 'TAX ID REQUIRED', 'type' => 'warning');
            } else if (empty($supplierName)) {
                $res = array('msg' => 'SUPPLIER NAME REQUIRED', 'type' => 'warning');
            } else if (empty($supplierPhone)) {
                $res = array('msg' => 'PHONE NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($supplierEmail)) {
                $res = array('msg' => 'EMAIL REQUIRED', 'type' => 'warning');
            } else if (empty($supplierAddress)) {
                $res = array('msg' => 'ADDRESS REQUIRED', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $verifyTaxID = $this->model->getSupplierValidate('TaxID', $supplierTaxID, 'register', 0);
                    $verifyName = $this->model->getSupplierValidate('name', $supplierName, 'register', 0);
                    $verifyPhone = $this->model->getSupplierValidate('phone_number', $supplierPhone, 'register', 0);
                    $verifyEmail = $this->model->getSupplierValidate('email', $supplierEmail, 'register', 0);

                    if (!empty($verifyTaxID)) {
                        $res = array('msg' => 'TAX ID MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyPhone)) {
                        $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyEmail)) {
                        $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                    } else {
                        $data = $this->model->regSupplier(
                            $supplierTaxID,
                            $supplierName,
                            $supplierPhone,
                            $supplierEmail,
                            $supplierAddress
                        );
                        if ($data > 0) {
                            $res = array('msg' => 'SUPPLIER REGISTERED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'SUPPLIER WAS NOT REGISTERED', 'type' => 'error');
                        }
                    }
                } else {
                    $verifyTaxID = $this->model->getSupplierValidate('taxID', $supplierTaxID, 'update', $id);
                    $verifyName = $this->model->getSupplierValidate('name', $supplierName, 'update', $id);
                    $verifyPhone = $this->model->getSupplierValidate('phone_number', $supplierPhone, 'update', $id);
                    $verifyEmail = $this->model->getSupplierValidate('email', $supplierEmail, 'update', $id);

                    if (!empty($verifyTaxID)) {
                        $res = array('msg' => 'TAX ID MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyPhone)) {
                        $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyEmail)) {
                        $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                    } else {
                        $data = $this->model->modSupplier(
                            $supplierTaxID,
                            $supplierName,
                            $supplierPhone,
                            $supplierEmail,
                            $supplierAddress,
                            $id
                        );
                        if ($data > 0) {
                            $res = array('msg' => 'SUPPLIER UPDATED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'SUPPLIER WAS NOT UPDATED', 'type' => 'error');
                        }
                    }
                }
            }
        } else {
            $res = array('msg' => 'ERROR, SUPPLIER WAS NOT REGISTERED', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delSupplier($idSupplier)
    {
        if (isset($_GET)) {
            if (is_numeric($idSupplier)) {
                $data = $this->model->eraseSupplier(0, $idSupplier);
                if ($data > 0) {
                    $res = array('msg' => 'SUPPLIER DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'SUPPLIER WAS NOT DELETED', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function modifySuppliers($idSupplier)
    {
        $data = $this->model->updateSupplier($idSupplier);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactiveSupplier()
    {
        $data['title'] = 'Inactive Suppliers';
        $data['script'] = 'supplierInactive.js';
        $this->views->getView('Suppliers', 'inactSuppliers', $data);
    }
    public function listInactiveSuppliers()
    {
        $data = $this->model->getSuppliers(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreSupplier(' . $data[$i]['id'] . ')"><i class="fa fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function supplierRestore($idSuppliers)
    {
        if (isset($_GET)) {
            if (is_numeric($idSuppliers)) {
                $data = $this->model->eraseSupplier(1, $idSuppliers);
                if ($data > 0) {
                    $res = array('msg' => 'SUPPLIER RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'SUPPLIER WAS NOT RESTORED', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    //search suppliers data for tbl purchase
    public function searchSuppliers()
    {
        $array = array();
        $value = strClean($_GET['term']);
        $data = $this->model->searchSData($value);

        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['name'];
            $result['phone'] = $row['phone_number'];
            $result['address'] = $row['address'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function generateOrderNumber()
    {
        $serialNumber = "";
        $count = 0;
        for ($n = 0; $n < 2; $n++) {
            if ($count == 0) {
                for ($i = 0; $i < 4; $i++) {
                    $randNumber = rand(65, 90);
                    $serialNumber .= chr($randNumber);
                }
            } else {
                for ($i = 0; $i < 3; $i++) {
                    $randNumber = rand(97, 122);
                    $serialNumber .= chr($randNumber);
                }
            }
            for ($i = 0; $i < 6; $i++) {
                $randNumber = rand(0, 9);
                $serialNumber .= $randNumber;
            }
            $count++;
        }
        $data = $this->model->validateOrderNumber($serialNumber);
        if (empty($data)) {
            echo json_encode($serialNumber, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            $this->generateOrderNumber();
        }
    }
}
