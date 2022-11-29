<?php
//require 'vendor/autoload.php';

// reference the Dompdf namespace
//use Dompdf\Dompdf;

class CashRegister extends Controller
{
    private $idUser;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->idUser = $_SESSION['id_user'];
    }
    public function index()
    {
        $data['title'] = 'Cash Register Details';
        $data['script'] = 'cash_register.js';
        $data['cashRegister'] = $this->model->verifyIfOpen($this->idUser);
        $this->views->getView('cash_register', 'index', $data);
    }
    public function openRegister()
    {
        $json = file_get_contents('php://input');
        $dataCRegister = json_decode($json, true);

        if (empty($dataCRegister['amount'])) {
            $res = array('msg' => 'AMOUNT IS REQUIRED', 'type' => 'warning');
        } else {
            $verifyOpen = $this->model->verifyIfOpen($this->idUser);
            if (empty($verifyOpen)) {
                $openDate = date('Y-m-d H:i:s');
                $amount = strClean($dataCRegister['amount']);
                $data = $this->model->openCashRegister($amount, $openDate, $this->idUser);

                if ($data > 0) {
                    $res = array('msg' => 'CASH REGISTER OPENED SUCCESSFULLY', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR OPENING CASH REGISTER', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'CASH REGISTER IS OPEN', 'type' => 'warning');
            }

            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }
    public function listOpenClose()
    {
        $data = $this->model->getOpenClose();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerExpense()
    {
        if (isset($_POST['expenseAmount']) && isset($_POST['description'])) {
            if (empty($_POST['expenseAmount'])) {
                $res = array('msg' => 'EXPENSE AMOUNT IS REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['description'])) {
                $res = array('msg' => 'DESCRIPTION IS REQUIRED', 'type' => 'warning');
            } else {
                $amount = strClean($_POST['expenseAmount']);
                $description = strClean($_POST['description']);
                
                $expensePhoto = $_FILES['expensePhoto'];
                $actualPhoto = strClean($_POST['actualPhoto']);
                $namePhoto = $expensePhoto['name'];
                $tmpPhoto = $expensePhoto['tmp_name'];
    
                $photoDirectory = null;
                if (!empty($namePhoto)) {
                    $dates = date('YmdHis');
                    $photoDirectory = 'assets/images/expenses/' . $dates . '.jpg';
                } else if (!empty($actualPhoto) && empty($namePhoto)) {
                    $photoDirectory = $actualPhoto;
                }
                $data = $this->model->regExpenses($amount, $description, $photoDirectory, $this->idUser);
    
                if ($data > 0) {
                    if (!empty($namePhoto)) {
                        move_uploaded_file($tmpPhoto, $photoDirectory);
                    }
                    $res = array('msg' => 'EXPENSE REGISTERED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR EXPENSE WAS NOT REGISTERED', 'type' => 'error');
                }
                
            }
        } else {
            $res = array('msg' => 'ERROR, EXPENSE WAS NOT REGISTERED', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
