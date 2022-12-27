<?php
require 'vendor/autoload.php';

//reference the Dompdf namespace
use Dompdf\Dompdf;

class CashRegister extends Controller
{
    private $idUser;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
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
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['action'] = '<a href="' . BASE_URL . 'CashRegister/historyReport/' . $data[$i]['id'] . '" target="_blank" class="btn btn-danger"><i class="fas fa-file-pdf"></i></a>';
        }
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
                $verifyExpense = $this->getData();
                if ($amount >= $verifyExpense['balance'] || $amount >= $verifyExpense['safeCash']) {
                    $res = array('msg' => 'THERE IS NO MONEY TO EXPENSES', 'type' => 'warning');
                } else {
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
            }
        } else {
            $res = array('msg' => 'ERROR, EXPENSE WAS NOT REGISTERED', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
    public function listExpenseHistory()
    {
        $data = $this->model->getExpenseHistory();
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['photo'] = '<a href="' . BASE_URL . $data[$i]['photo'] . '" target="_blank">
                <img class="img-thumbnail" src="' . BASE_URL . $data[$i]['photo'] . '" width="100">
                </a>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //for cash movementgraph representation
    public function cashMovement()
    {
        $data = $this->getData();
        $data['currency'] = CURRENCY;
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function getData()
    {
        $consultReserves = $this->model->getCashReserves($this->idUser);
        $reserves = ($consultReserves['total'] != null) ? $consultReserves['total'] : 0;

        $consultSales = $this->model->getCashSales('total', $this->idUser);
        $sales = ($consultSales['total'] != null) ? $consultSales['total'] : 0;

        $consultDiscount = $this->model->getCashSales('discount_amount', $this->idUser);
        $discount = ($consultDiscount['total'] != null) ? $consultDiscount['total'] : 0;

        $consultDeposits = $this->model->getCashDeposits($this->idUser);
        $deposits = ($consultDeposits['total'] != null) ? $consultDeposits['total'] : 0;

        $consultPurchases = $this->model->getCashPurchase($this->idUser);
        $purchases = ($consultPurchases['total'] != null) ? $consultPurchases['total'] : 0;

        $consultExpenses = $this->model->getCashExpense($this->idUser);
        $expenses = ($consultExpenses['total'] != null) ? $consultExpenses['total'] : 0;

        $consultCredits = $this->model->getCashCredits($this->idUser);
        $credits = ($consultCredits['total'] != null) ? $consultCredits['total'] : 0;

        $initialAmount = $this->model->verifyIfOpen($this->idUser);

        $data['outcome'] = number_format($purchases + $expenses, 2, '.', '');
        $data['income'] = number_format($sales + $deposits + $reserves, 2, '.', '');
        $data['initialAmount'] = ((!empty($initialAmount['initial_amount'])) ? number_format($initialAmount['initial_amount'], 2, '.', '') : 0);
        $data['credits'] = number_format($credits, 2, '.', '');
        $data['expenses'] = number_format($expenses, 2, '.', '');
        $data['balance'] = number_format((($data['income'] + $data['initialAmount']) - ($data['outcome'] + $data['expenses'])), 2, '.', '');
        $data['safeCash'] = number_format(($data['balance'] * 0.85), 2, '.', '');
        $data['discount'] = number_format($discount, 2, '.', '');

        $data['outcomeDecimal'] = number_format($data['outcome'], 2);
        $data['incomeDecimal'] = number_format($data['income'], 2);
        $data['initialAmountDecimal'] = number_format($data['initialAmount'], 2);
        $data['creditsDecimal'] = number_format($data['credits'], 2);
        $data['expensesDecimal'] = number_format($data['expenses'], 2);
        $data['balanceDecimal'] = number_format($data['balance'], 2);
        $data['discountDecimal'] = number_format($data['discount'], 2);

        return $data;
    }
    public function reports()
    {
        ob_start();

        $data['title'] = 'Reports';
        $data['actual'] = true;
        $data['companies'] = $this->model->getCompanies();
        $data['movements'] = $this->getData();
        //Just for testing
        // print_r($data['movements']);
        // exit;
        if (empty($data['movements']['initialAmount'])) {
            echo 'Page not Found';
            exit;
        }
        $this->views->getView('cash_register', 'report', $data);
        $html = ob_get_clean();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('report.pdf', array('Attachment' => false));
    }
    public function closeCashRegister()
    {
        $data = $this->getData();
        // Just for testing
        //print_r($data);
        $closeDate = date('Y-m-d H:i:s');
        $finalAmount = $data['income'];
        $sales = $this->model->getCRegisterSales($this->idUser);
        $totalSales = $sales['total'];
        $outCome = $data['outcome'];
        $expenses = $data['expenses'];

        $result = $this->model->cashRegisterClose($closeDate, $finalAmount, $totalSales, $outCome, $expenses, $this->idUser);
        if ($result > 0) {
            $this->model->updateOpenCRegister('deposit', $this->idUser);
            $this->model->updateOpenCRegister('purchases', $this->idUser);
            $this->model->updateOpenCRegister('sales', $this->idUser);
            $this->model->updateOpenCRegister('expenses', $this->idUser);
            $this->model->updateOpenCRegister('detail_reserve', $this->idUser);
            $this->model->updateOpenCRegister('credits', $this->idUser);

            $res = array('msg' => 'CASH REGISTER CLOSED', 'type' => 'success');
        } else {
            $res = array('msg' => 'ERROR CLOSING CASH REGISTER', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function historyReport($idCashRegister)
    {
        ob_start();

        $data['title'] = 'Report Cash Register: '. $idCashRegister;
        $data['actual'] = false;
        $data['idCRegister'] = $idCashRegister;

        $data['companies'] = $this->model->getCompanies();
        $data['move'] = $this->getData();
        $dataCRegister = $this->model->getHistoryData($idCashRegister);
        $data['movements']['initialAmountDecimal'] = number_format($dataCRegister['initial_amount'], 2);
        $data['movements']['incomeDecimal'] = number_format($dataCRegister['final_amount'], 2);
        $data['movements']['expensesDecimal'] = number_format($dataCRegister['expenses'], 2);
        $data['movements']['outcomeDecimal'] = number_format($dataCRegister['outcome'], 2);
        $data['movements']['balanceDecimal'] = number_format(($dataCRegister['initial_amount'] + $dataCRegister['final_amount'] - $dataCRegister['outcome'] - $dataCRegister['expenses']), 2);
        //Just for testing
        // print_r($data['movements']);
        // exit;
        if (empty($data['movements']['initialAmountDecimal'])) {
            echo 'Page not Found';
            exit;
        }
        $this->views->getView('cash_register', 'report', $data);
        $html = ob_get_clean();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('report.pdf', array('Attachment' => false));
    }
}
