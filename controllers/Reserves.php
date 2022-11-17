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

            $createdDate = date('Y-m-d H:i:s');
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
                $totalAmount = $subTotalAmount - $depositAmount;
                $productData = json_encode($array['products']);
                $reserves = $this->model->regReserveOrder(
                    $productData,
                    $reserveDate,
                    $withdrawDate,
                    $depositAmount,
                    $totalAmount,
                    $color,
                    $idClient,
                    $this->idUser
                );
                if ($reserves > 0) {
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
        for ($i=0; $i < count($data); $i++) {
            $data[$i]['title'] = $data[$i]['name'] . ' - ' . $data[$i]['num_identity'];
            $data[$i]['color'] = $data[$i]['color'];
            $data[$i]['start'] = $data[$i]['dates_reserves'];
            $data[$i]['end'] = $data[$i]['dates_withdraw'];

        }
        echo json_encode($data);
        die();
    }
}
