<?php

class Measures extends Controller
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
        $data['title'] = 'Measures';
        $data['script'] = 'measures.js';
        $this->views->getView('measures', 'index', $data);
    }
    public function listMeasures()
    {
        $data = $this->model->getMeasures(1);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteMeasure(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editMeasure(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerMeasures()
    {
        if (isset($_POST['measureName'])) {
                    
        $id = strClean($_POST['idMeasure']);
        $measureName = strClean($_POST['measureName']);
        $shortName = strClean($_POST['shortName']);

        if (empty($measureName)) {
            $res = array('msg' => 'MEASURE NAME IS REQUIRED', 'type' => 'warning');
        } else if (empty($shortName)) {
            $res = array('msg' => 'SHORT NAME IS REQUIRED', 'type' => 'warning');
        } else {
            if ($id == '') {
                $verifyMeasure = $this->model->getMeasureValidate('measure', $measureName, 'register', 0);
                if (empty($verifyMeasure)) {
                    $data = $this->model->regMeasures($measureName, $shortName);
                    if ($data > 0) {
                        $res = array('msg' => 'MEASURE REGISTERED', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'MEASURE WAS NOT REGISTERED', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'MEASURE ALREADY EXIST', 'type' => 'warning');
                }
            } else {
                $verifyMeasure = $this->model->getMeasureValidate('measure', $measureName, 'update', $id);
                if (empty($verifyMeasure)) {
                    $data = $this->model->modMeasure($measureName, $shortName, $id);
                    if ($data > 0) {
                        $res = array('msg' => 'MEASURE UPDATED', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'MEASURE WAS NOT UPDATED', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'MEASURE ALREADY EXIST', 'type' => 'warning');
                }
            }
        }
        } else {
            $res = array('msg' => 'MEASURE WAS NOT UPDATED', 'type' => 'error');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delMeasure($idMeasure)
    {
        if (isset($_GET)) {
            if (is_numeric($idMeasure)) {
                $data = $this->model->eraseMeasure(0, $idMeasure);
                if ($data > 0) {
                    $res = array('msg' => 'MEASURE DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'MEASURE WAS NOT DELETED', 'type' => 'error');
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
    public function modifyMeasures($idMeasure)
    {
        $data = $this->model->updateMeasure($idMeasure);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactiveMeasure()
    {
        $data['title'] = 'Inactive Measures';
        $data['script'] = 'measureIncative.js';
        $this->views->getView('measures', 'inactMeasure', $data);
    }
    public function listInactiveMeasures()
    {
        $data = $this->model->getMeasures(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreMeasure(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>
          </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function measureRestore($idMeasure)
    {
        if (isset($_GET)) {
            if (is_numeric($idMeasure)) {
                $data = $this->model->eraseMeasure(1, $idMeasure);
                if ($data > 0) {
                    $res = array('msg' => 'MEASURE RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'MEASURE WAS NOT RESTORED', 'type' => 'error');
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
}
