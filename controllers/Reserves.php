<?php
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Reserves extends Controller
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
        $data['title'] = 'Reserves';
        $data['script'] = 'reserves.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'postReserves';
        $this->views->getView('reserves', 'index', $data);
    }
    public function registerReserves()
    {
        $json = file_get_contents('php://input');
        $dataReserves = json_decode($json, true);
        $array['products'] = array();
        $totalAmount = 0;

        if (!empty($dataReserves['products'])) {

            $dateCreated = date('Y-m-d');
            $timeCreated = date('H:i:s');
            $reserveDate = $dataReserves['reserveDate'] . ' ' . date('H:i:s');
            $withdrawDate = $dataReserves['withdrawDate'] . ' 23:59:59'; //change here depending fo the hour where the business close
            $depositAmount = $dataReserves['depositAmount'];
            $color = $dataReserves['dateColor'];
            $subTotalAmount = 0;

            $idClient = $dataReserves['idClient'];

            if (empty($idClient)) {
                $res = array('msg' => 'CLIENT REQUIRED', 'type' => 'warning');
            } else if (empty($reserveDate)) {
                $res = array('msg' => 'RESERVE DATE REQUIRED', 'type' => 'warning');
            } else if (empty($withdrawDate)) {
                $res = array('msg' => 'WITHDRAW DATE REQUIRED', 'type' => 'warning');
            } else if (empty($depositAmount)) {
                $res = array('msg' => 'DEPOSIT AMOUNT REQUIRED', 'type' => 'warning');
            } else {
                foreach ($dataReserves['products'] as $product) {

                    $result = $this->model->getReserveList($product['id']);
                    $data['id'] = $result['id'];
                    $data['name'] = $result['description'];
                    $data['sale_price'] = $result['sale_price'];
                    $data['quantity'] = $product['quantity'];
                    $subTotal = $result['sale_price'] * $product['quantity'];
                    array_push($array['products'], $data);
                    $subTotalAmount += $subTotal;
                }
                $totalAmount = $subTotalAmount;
                $totalReamaining = $totalAmount - $depositAmount;
                $productData = json_encode($array['products']);
                $reserves = $this->model->regReserveOrder(
                    $productData,
                    $dateCreated,
                    $timeCreated,
                    $reserveDate,
                    $withdrawDate,
                    $depositAmount,
                    $totalAmount,
                    $totalReamaining,
                    $color,
                    $idClient,
                    $this->idUser
                );
                if ($reserves > 0) {
                    $actionSale = 'OUT PRODUCT';
                    $currentDate = date('Y-m-d');
                    $currentTime = date('H:i:s');
                    foreach ($dataReserves['products'] as $product) {
                        $result = $this->model->getReserveList($product['id']);
                        //update stock
                        $newQuantity = $result['quantity'] - $product['quantity'];
                        $this->model->updateQuantity($newQuantity, $product['id']);
                        //inventory movement
                        $movement = 'Reserve N°: ' . $reserves;
                        $quantity = -$product['quantity'];
                        $this->model->registerInvMovement($movement, $actionSale, $quantity, $currentDate, $currentTime, $result['code'], $result['photo'], $product['id'], $this->idUser);
                    }
                    $res = array('msg' => 'RESERVE ORDER GENERATED', 'type' => 'success', 'idReserve' => $reserves);
                } else {
                    $res = array('msg' => 'RESERVE ORDER NOT GENERATED', 'type' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'EMPTY CART', 'type' => 'warning');
        }
        echo json_encode($res);
        die();
    }
    public function reports($fields)
    {
        ob_start();

        $array = explode(',', $fields);
        $type = $array[0];
        $idReserves = $array[1];

        $data['title'] = 'Statements';
        $data['companies'] = $this->model->getCompanies();
        $data['reserves'] = $this->model->getReserves($idReserves);
        if (empty($data['reserves'])) {
            echo 'Page not Found';

            exit;
        }
        $this->views->getView('reserves', $type, $data);
        $html = ob_get_clean();
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        if ($type == 'tickets') {
            $dompdf->setPaper(array(0, 0, 130, 841), 'portrait');
        } else {
            $dompdf->setPaper('A4', 'vertical');
        }
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('report.pdf', array('Attachment' => false));
    }
    public function listCalendarReserves()
    {
        $data = $this->model->getCalendarReserves();
        for ($i = 0; $i < count($data); $i++) {
            $status = ($data[$i]['status'] == 0) ? 'Completed' : 'Pending';
            if ($data[$i]['status'] == 0) {
                $status = 'Completed';
            } else if ($data[$i]['status'] == 1) {
                $status = 'Pending';
            } else {
                $status = 'Cancelled';
            }            
            $data[$i]['title'] =  $status . ' - ' . $data[$i]['name'] . ' - ' . $data[$i]['num_identity'];
            $data[$i]['color'] = $data[$i]['colors'];
            $data[$i]['start'] = $data[$i]['dates_reserves'];
            $data[$i]['end'] = $data[$i]['dates_withdraw'];
        }
        echo json_encode($data);
        die();
    }
    public function listRecordReserves()
    {
        $data = $this->model->getCalendarReserves();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 0) {
                $data[$i]['status'] = '<span class="badge bg-success" style="color: black; font-size: 14px;">Completed</span>';
            } else if ($data[$i]['status'] == 2) {
                $data[$i]['status'] = '<span class="badge bg-danger" style="color: black; font-size: 14px;">Cancelled</span>';
            } else {
                $data[$i]['status'] = '<span class="badge bg-warning" style="color: black; font-size: 14px;">Pending</span>';
            }
            $data[$i]['client'] = '<span class="badge" style="color: black; font-size: 14px; background: ' . $data[$i]['colors'] . ';">' . $data[$i]['name'] . '</span>';
            $data[$i]['actions'] = '<a class="btn btn-danger" href="#" onclick="showReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>';
        }
        echo json_encode($data);
        die();
    }
    public function deliveryShowData($idReserve)
    {
        $data = $this->model->getDataReserves($idReserve);
        echo json_encode($data);
        die();
    }
    public function processDelivery($idReserve)
    {
        $importData = $this->model->getDataReserves($idReserve);
        $data = $this->model->setProcessDelivery($importData['total'], 0, 0, $idReserve);

        if ($data > 0) {
            $res = array('msg' => 'DELIVERY PROCESSED', 'type' => 'success');
        } else {
            $res = array('msg' => 'ERROR DELIVERY WAS NOT PROCESSED', 'type' => 'error');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function deleteReserve($idReserves)
    {
        $data = $this->model->cancelReserve(0, 0, 2, $idReserves);

        if ($data > 0) {
            $actionSale = 'IN PRODUCT';
            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');
            $resultReserve = $this->model->getReserves($idReserves);
            $stockSale = json_decode($resultReserve['products'], true);

            foreach ($stockSale as $product) {
                $result = $this->model->getReserveList($product['id']);
                //update stock
                $newQuantity = $result['quantity'] + $product['quantity'];
                $this->model->updateQuantity($newQuantity, $product['id']);
                //inventory movement
                $movement = 'Reserve N°: ' . $idReserves;
                $quantity = $product['quantity'];
                $this->model->registerInvMovement($movement, $actionSale, $quantity, $currentDate, $currentTime, $result['code'], $result['photo'], $product['id'], $this->idUser);
            }
            $res = array('msg' => 'RESERVE CANCELLED', 'type' => 'success');
        } else {
            $res = array('msg' => 'ERROR DELIVERY WAS NOT CANCELLED', 'type' => 'error');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
