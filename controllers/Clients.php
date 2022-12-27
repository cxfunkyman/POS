<?php

class Clients extends Controller
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
        $data['title'] = 'Clients';
        $data['script'] = 'clients.js';
        $this->views->getView('clients', 'index', $data);
    }
    public function listClients()
    {
        $data = $this->model->getClients(1);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteClient(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editClient(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerClients()
    {
        if (isset($_POST['clientID']) && isset($_POST['clientIDNumb'])) {
            $id = strClean($_POST['idClient']);
            $clientID = strClean($_POST['clientID']);
            $clientIDNumb = strClean($_POST['clientIDNumb']);
            $clientName = strClean($_POST['clientName']);
            $clientPhone = strClean($_POST['clientPhone']);
            $clientEmail = (empty($_POST['clientEmail'])) ? null : strClean($_POST['clientEmail']);
            $clientAddress = strClean($_POST['clientAddress']);

            if (empty($clientID)) {
                $res = array('msg' => 'TYPE REQUIRED', 'type' => 'warning');
            } else if (empty($clientIDNumb)) {
                $res = array('msg' => 'ID NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($clientName)) {
                $res = array('msg' => 'CLIENT NAME REQUIRED', 'type' => 'warning');
            } else if (empty($clientPhone)) {
                $res = array('msg' => 'PHONE NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($clientAddress)) {
                $res = array('msg' => 'ADDRESS REQUIRED', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $verifyIDNumb = $this->model->getClientValidate('num_identity', $clientIDNumb, 'register', 0);
                    $verifyName = $this->model->getClientValidate('name', $clientName, 'register', 0);
                    $verifyPhone = $this->model->getClientValidate('phone_number', $clientPhone, 'register', 0);
                    $verifyEmail = $this->model->getClientValidate('email', $clientEmail, 'register', 0);

                    if (!empty($verifyIDNumb)) {
                        $res = array('msg' => 'ID NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyPhone)) {
                        $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if ($verifyEmail != null) {
                        if (!empty($verifyEmail)) {
                            $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                        }
                    } else {
                        $data = $this->model->regClient(
                            $clientID,
                            $clientIDNumb,
                            $clientName,
                            $clientPhone,
                            $clientEmail,
                            $clientAddress
                        );
                        if ($data > 0) {
                            $res = array('msg' => 'CLIENT REGISTERED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'CLIENT WAS NOT REGISTERED', 'type' => 'error');
                        }
                    }
                } else {
                    $verifyIDNumb = $this->model->getClientValidate('num_identity', $clientIDNumb, 'update', $id);
                    $verifyName = $this->model->getClientValidate('name', $clientName, 'update', $id);
                    $verifyPhone = $this->model->getClientValidate('phone_number', $clientPhone, 'update', $id);
                    $verifyEmail = $this->model->getClientValidate('email', $clientEmail, 'update', $id);

                    if (!empty($verifyIDNumb)) {
                        $res = array('msg' => 'ID NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyPhone)) {
                        $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                    } else if ($verifyEmail != null) {
                        if (!empty($verifyEmail)) {
                            $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                        }
                    } else {
                        $data = $this->model->modClient(
                            $clientID,
                            $clientIDNumb,
                            $clientName,
                            $clientPhone,
                            $clientEmail,
                            $clientAddress,
                            $id
                        );
                        if ($data > 0) {
                            $res = array('msg' => 'CLIENT UPDATED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'CLIENT WAS NOT UPDATED', 'type' => 'error');
                        }
                    }
                }
            }
        } else {
            $res = array('msg' => 'ERROR, CLIENT WAS NOT REGISTERED', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delClient($idClient)
    {
        if (isset($_GET)) {
            if (is_numeric($idClient)) {
                $data = $this->model->eraseClient(0, $idClient);
                if ($data > 0) {
                    $res = array('msg' => 'CLIENT DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CLIENT WAS NOT DELETED', 'type' => 'error');
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
    public function modifyClients($idClient)
    {
        $data = $this->model->updateClient($idClient);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactiveClient()
    {
        $data['title'] = 'Inactive Clients';
        $data['script'] = 'clientIncative.js';
        $this->views->getView('Clients', 'inactClients', $data);
    }
    public function listInactiveClients()
    {
        $data = $this->model->getClients(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreClient(' . $data[$i]['id'] . ')"><i class="fa fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function clientRestore($idClients)
    {
        if (isset($_GET)) {
            if (is_numeric($idClients)) {
                $data = $this->model->eraseClient(1, $idClients);
                if ($data > 0) {
                    $res = array('msg' => 'CLIENT RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CLIENT WAS NOT RESTORED', 'type' => 'error');
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
    //search clients data for tbl clients
    public function searchClients()
    {
        $array = array();
        $value = strClean($_GET['term']);
        $data = $this->model->searchCData($value);

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
}
