<?php
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Inventory extends Controller
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
        $data['title'] = 'Inventory';
        $data['script'] = 'inventory.js';
        $this->views->getView('inventory', 'index', $data);
    }
    public function listInvMovement($months)
    {
        if (empty($months)) {
            $data = $this->model->getInvMovement();

            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['photo'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" alt="Photo goes here" width="80">';
            }
        } else {
            $array = explode('-', $months);
            $year = $array[0];
            $month = $array[1];
            $data = $this->model->getMoveByMonth($year, $month);
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['photo'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" alt="Photo goes here" width="80">';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function report($months)
    {
        $data['companies'] = $this->model->getCompanies();

        if (empty($months)) {
            $data['inventory'] = $this->model->getInvMovement();
        } else {
            $array = explode('-', $months);
            $year = $array[0];
            $month = $array[1];
            $data['inventory'] = $this->model->getMoveByMonth($year, $month);
        }
        ob_start();
        $this->views->getView('inventory', 'report', $data);
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
    public function processAdjust()
    {
        $json = file_get_contents('php://input');
        $dataAdjust = json_decode($json, true);
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        //Just for testing
        //print_r($dataAdjust);

        if (empty($dataAdjust['idProduct'])) {
            $res = array('msg' => 'PRODUCT IS REQUIRED', 'type' => 'warning');
        } else if (empty($dataAdjust['quantity'])) {
            $res = array('msg' => 'QUANTITY ADJUSTMENT IS REQUIRED', 'type' => 'warning');
        } else {
            if (is_numeric($dataAdjust['idProduct']) && is_numeric($dataAdjust['quantity'])) {
                $idProduct = $dataAdjust['idProduct'];
                $quantity = $dataAdjust['quantity'];

                $product = $this->model->getProduct($idProduct);

                $newQuantity = $product['quantity'] + ($quantity);

                //Just for testing
                //print_r($newQuantity);
                $data = $this->model->regAdjustment($idProduct, $newQuantity, $this->idUser);

                if ($data > 0) {
                    //inventory movement
                    $actualStock = $newQuantity;
                    $oldStock = $product['quantity'];
                    $movement = 'Stock Adjustment';
                    $actionAdjust = ($quantity > 0) ? 'IN INVENTORY' : 'OUT INVENTORY';

                    $this->model->registerInvMovement($movement, $actionAdjust, $quantity, $oldStock, $actualStock, $currentDate, $currentTime, $product['code'], $product['photo'], $idProduct, $this->idUser);

                    $res = array('msg' => 'STOCK ADJUSTMENT SUCCESSFUL', 'type' => 'success');
                } else {
                    $res = array('msg' => 'STOCK ADJUSTMENT FAILED', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'STOCK ADJUSTMENT ERROR', 'type' => 'error');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function kardex($idProduct)
    {
        $data['companies'] = $this->model->getCompanies();
        $data['kardex'] = $this->model->getKardex($idProduct);

        for ($i = 0; $i < count($data['kardex']); $i++) {
            $data['kardex'][$i]['in_stock'] = 0;
            $data['kardex'][$i]['out_stock'] = 0;

            if ($data['kardex'][$i]['action'] == 'IN INVENTORY') {
                $data['kardex'][$i]['in_stock'] = $data['kardex'][$i]['quantity'];
            } else {
                $data['kardex'][$i]['out_stock'] = $data['kardex'][$i]['quantity'];
            }
        }
        ob_start();
        $this->views->getView('inventory', 'kardex', $data);
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
