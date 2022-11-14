<?php
require 'vendor/autoload.php';
// reference the Dompdf namespace
use Dompdf\Dompdf;

class Purchases extends Controller
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
        $data['title'] = 'Purchases';
        $data['script'] = 'purchases.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'postPurchase';
        $this->views->getView('purchases', 'index', $data);
    }
    public function registerOrder()
    {
        $json = file_get_contents('php://input');
        $dataProducts = json_decode($json, true);
        $totalPrice = 0;
        $subTotalPrice = 0;
        $array['products'] = array();

        if (!empty($dataProducts['products'])) {
            //$index = $dataProducts['purchaseNumber'];
           // $serieCode = $this->randomNumbers($index, 1, 8);

            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');
            $purchaseNumber = $dataProducts['purchaseNumber'];
            $idSupplier = $dataProducts['idSupplier'];

            if (empty($idSupplier)) {
                $res = array('msg' => 'SUPPLIER REQUIRED', 'type' => 'warning');
            } else if (empty($purchaseNumber)) {
                $res = array('msg' => 'PURCHASE NUMBER REQUIRED', 'type' => 'warning');
            } else {
                foreach ($dataProducts['products'] as $product) {

                    $result = $this->model->getProductList($product['id']);
                    $data['id'] = $result['id'];
                    $data['name'] = $result['description'];
                    $data['purchase_price'] = $result['purchase_price'];
                    $data['quantity'] = $product['quantity'];
                    $subTotal = $result['purchase_price'] * $product['quantity'];
                    array_push($array['products'], $data);
                    $subTotalPrice += $subTotal;
                    //update stock
                    $newQuantity = $result['quantity'] + $product['quantity'];
                    $this->model->updateQuantity($newQuantity, $result['id']);
                }

                $tps = $subTotalPrice * 0.05;
                $tvq = $subTotalPrice * 0.09975;
                $totalPrice = $subTotalPrice + $tps + $tvq;

                $productData = json_encode($array['products']);
                $purchase = $this->model->regProductOrder(
                    $productData,
                    $subTotalPrice,
                    $totalPrice,
                    $tps,
                    $tvq,
                    $currentDate,
                    $currentTime,
                    $purchaseNumber,
                    $idSupplier,
                    $this->idUser
                );
                if ($purchase > 0) {
                    $res = array('msg' => 'PURCHASE GENERATED', 'type' => 'success', 'idPurchase' => $purchase);
                } else {
                    $res = array('msg' => 'PURCHASE NOT GENERATED', 'type' => 'error');
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
        $array = explode(',', $fields);
        $type = $array[0];
        $idPurchases = $array[1];

        $data['title'] = 'Statements';
        $data['companies'] = $this->model->getCompanies();
        $data['purchases'] = $this->model->getPurchases($idPurchases);
        if (empty($data['purchases'])) {
            echo 'Page not Found';
            exit;
        }
        $this->views->getView('purchases', $type, $data);
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
            $dompdf->setPaper(array(0, 0, 222, 841), 'portrait');
        } else {
            $dompdf->setPaper('A4', 'vertical');
        }
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('ticket.pdf', array('Attachment' => false));
    }
    public function listRecords()
    {
        $data = $this->model->listRecords();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 1) {
                $data[$i]['actions'] = '<div>
                <a class="btn btn-warning" href="#" onclick="deletePurchase(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></a>
                <a class="btn btn-danger" href="#" onclick="showReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
                </div>';
            } else {
                $data[$i]['actions'] = '<div>
                <span class="badge bg-info">Canceled</span>
                <a class="btn btn-danger" href="#" onclick="showReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
                </div>';
            }
        }
        echo json_encode($data);
        die();
    }
    public function cancelOrder($idPurchase)
    {
        if (isset($_GET) && is_numeric($idPurchase)) {
            $data = $this->model->dropOrder($idPurchase);
            if ($data > 0) {
                $resultPurchase = $this->model->getPurchases($idPurchase);
                $stockPurchase = json_decode($resultPurchase['products'], true);
                foreach ($stockPurchase as $product) {
                    $result = $this->model->getProductList($product['id']);
                    //update stock
                    $newQuantity = $result['quantity'] - $product['quantity'];
                    $this->model->updateQuantity($newQuantity, $product['id']);
                }

                $res = array('msg' => 'ORDER CANCELLED', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR, ORDER NOT CANCELLED', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'Unknown Error', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
