<?php

require 'vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

class Credits extends Controller
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
        $data['title'] = 'Credits';
        $data['script'] = 'credits.js';
        $this->views->getView('credits', 'index', $data);
    }
    public function listCredits()
    {
        $data = $this->model->getCredits();

        for ($i = 0; $i < count($data); $i++) {
            $credits = $this->model->getAbonateCredits($data[$i]['id']);
            $result = $this->model->getDeposits($data[$i]['id']);
            $deposits = ($result['total'] == null) ? 0 : $result['total'];
            $remaining = $data[$i]['amount'] - $deposits;
            if ($remaining < 1 && $credits['status'] == 1) {
                $this->model->updateCredits(0, $data[$i]['id']);
            }
            $data[$i]['amount'] = number_format($data[$i]['amount'], 2);
            $data[$i]['deposit'] = number_format($deposits, 2);
            $data[$i]['remaining'] = number_format($remaining, 2);
            $data[$i]['sales'] = 'Nº: ' . $data[$i]['id_sale'];
            $data[$i]['actions'] = '<a class="btn btn-danger" href="' . BASE_URL . 'credits/reports/' . $data[$i]['id'] . '" target="_blank"><i class="fas fa-file-pdf"></i></a>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //search clients data for tbl clients
    public function searchClients()
    {
        $array = array();
        $value = strClean($_GET['term']);
        $data = $this->model->searchCreditData($value);

        foreach ($data as $row) {
            $resultDeposit = $this->model->getDeposits($row['id']);
            $deposits = ($resultDeposit['total'] == null) ? 0 : $resultDeposit['total'];
            $remaining = $row['amount'] - $deposits;
            $result['amount'] = $row['amount'];
            $result['deposit'] = $deposits;
            $result['remaining'] = $remaining;
            $result['dates'] = $row['dates'];

            $result['id'] = $row['id'];
            $result['label'] = $row['name'];
            $result['phone'] = $row['phone_number'];
            $result['address'] = $row['address'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function addAbonateDeposit()
    {
        $json = file_get_contents('php://input');
        $dataProducts = json_decode($json, true);
        if (!empty($dataProducts)) {
            $idCredit = strClean($dataProducts['idCredit']);
            $depositAmount = strClean($dataProducts['depositAmount']);
            $data = $this->model->regiterDeposit($depositAmount, $idCredit, $this->idUser);
            if ($data > 0) {
                $res = array('msg' => 'DEPOSIT REGISTERED', 'type' => 'success');
            } else {
                $res = array('msg' => 'DEPOSIT WAS NOT REGISTERED', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ALL FIELDS ARE REQUIRED', 'type' => 'warning');
        }
        echo json_encode($res);
        die();
    }
    public function reports($idCredits)
    {
        ob_start();

        $data['title'] = 'Report';
        $data['companies'] = $this->model->getCompanies();
        $data['credits'] = $this->model->getAbonateCredits($idCredits);
        $data['abonate'] = $this->model->getAbonates($idCredits);
        if (empty($data['credits'])) {
            echo 'Page not Found';
            exit;
        }
        $this->views->getView('credits', 'reports', $data);
        $html = ob_get_clean();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        //Setup the paper size and orientation
        $dompdf->setPaper('A4', 'vertical');
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('report.pdf', array('Attachment' => false));
    }
    public function listRecordsCredits()
    {
        $data = $this->model->getRecordsCredits();

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['credit'] = 'Nº: ' . $data[$i]['id_credit'];
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
