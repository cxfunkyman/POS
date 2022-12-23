<?php

class Admin extends Controller
{
    private $idUser;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->idUser = $_SESSION['id_user'];
    }
    // Use for graphic reports
    public function index()
    {
        $data['title'] = 'Admin Panel';
        $data['script'] = 'index.js'; // the script of the page is assigned to the array
        $data['users'] = $this->model->getTotalData('users');
        $data['clients'] = $this->model->getTotalData('clients');
        $data['supplier'] = $this->model->getTotalData('supplier');
        $data['products'] = $this->model->getTotalData('products');
        $data['topProducts'] = $this->model->topProducts();
        $data['newProducts'] = $this->model->newProducts();
        $data['minimumStock'] = $this->model->stockMinimum();
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
    // Graphic reports
    public function salesAndPurchases($year)
    {
        $from = $year . '-01-01';
        $to = $year . '-12-31';

        $data['sales'] = $this->model->monthlySales($from, $to, 'CASH', $this->idUser);
        $data['purchases'] = $this->model->monthlyPurchases($from, $to, $this->idUser);

        $data['totalSales'] = $this->model->getTotalSum($from, $to, 'subtotal', 'sales', $this->idUser);
        $data['totalPurchases'] = $this->model->getTotalSum($from, $to, 'subtotal', 'purchases', $this->idUser);

        $data['totalSalesDecimal'] = number_format($data['totalSales']['total'], 2);
        $data['totalPurchasesDecimal'] = number_format($data['totalPurchases']['total'], 2);
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function cashCreditsDiscount($year)
    {
        $from = $year . '-01-01';
        $to = $year . '-12-31';

        $data['cash'] = $this->model->monthlySales($from, $to, 'CASH', $this->idUser);
        $data['credit'] = $this->model->monthlySales($from, $to, 'CREDIT', $this->idUser);
        $data['discount'] = $this->model->monthlyDiscount($from, $to, 'CASH', $this->idUser);
        
        $data['totalCash'] = $this->model->getTotalSumData($from, $to, 'subtotal', 'sales', 'CASH', $this->idUser);
        $data['totalCredit'] = $this->model->getTotalSumData($from, $to, 'subtotal', 'sales', 'CREDIT', $this->idUser);
        $data['totalDiscount'] = $this->model->getTotalSumData($from, $to, 'discount_amount', 'sales', 'CASH', $this->idUser);

        $data['totalCashDecimal'] = number_format($data['totalCash']['total'], 2);
        $data['totalCreditDecimal'] = number_format($data['totalCredit']['total'], 2);
        $data['totalDiscountDecimal'] = number_format($data['totalDiscount']['total'], 2);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function topProductsGraph()
    {
        $data = $this->model->topProducts();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function expenses($year)
    {
        $from = $year . '-01-01';
        $to = $year . '-12-31';

        $data['expenses'] = $this->model->monthlyExpenses($from, $to, $this->idUser);
        $data['totalExpenses'] = $this->model->getTotalExpense($from, $to, 'amount', 'expenses', $this->idUser);
        $data['totalExpensesDecimal'] = number_format($data['totalExpenses']['total'], 2);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function minimumStock()
    {
        $data = $this->model->stockMinimum();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function reserves($year)
    {
        $from = $year . '-01-01';
        $to = $year . '-12-31';

        $data['completed'] = $this->model->countReserves($from, $to, 0, $this->idUser);
        $data['pending'] = $this->model->countReserves($from, $to, 1, $this->idUser);
        $data['cancelled'] = $this->model->countReserves($from, $to, 2, $this->idUser);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>
