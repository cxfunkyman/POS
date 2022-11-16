<?php
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Quotes extends Controller
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
        $data['title'] = 'Quotes';
        $data['script'] = 'quotes.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'postQuotes';
        $this->views->getView('quotes', 'index', $data);
    }
    public function reports($fields)
    {
        ob_start();
        
        $array = explode(',', $fields);
        $type = $array[0];
        $idQuotes = $array[1];

        $data['title'] = 'Statements';
        $data['companies'] = $this->model->getCompanies();
        $data['quotes'] = $this->model->getQuotes($idQuotes);
        if (empty($data['quotes'])) {
            echo 'Page not Found';
            
            exit;
        }
        $this->views->getView('quotes', $type, $data);
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
    public function registerQuotes()
    {
        $json = file_get_contents('php://input');
        $dataSales = json_decode($json, true);
        $totalPrice = 0;
        $subTotalPrice = 0;
        $priceSubtotal = 0;
        $discountAmount = 0;
        $array['products'] = array();

        if (!empty($dataSales['products'])) {

            $currentDate = date('Y-m-d');
            $currentTime = date('H:i:s');
            $payMethod = $dataSales['payMethod'];
            $quoteValidate = $dataSales['quoteValidate'];
            $discount = (!empty($dataSales['discount'])) ? $dataSales['discount'] : 0;
            
            $idClient = $dataSales['idClient'];

            if (empty($idClient)) {
                $res = array('msg' => 'CLIENT REQUIRED', 'type' => 'warning');
            } else if (empty($payMethod)) {
                $res = array('msg' => 'PAYMENT METHOD REQUIRED', 'type' => 'warning');
            }  else if (empty($quoteValidate)) {
                $res = array('msg' => 'OFFER VALIDITY REQUIRED', 'type' => 'warning');
            } else {
                foreach ($dataSales['products'] as $product) {

                    $result = $this->model->getSaleList($product['id']);
                    $data['id'] = $result['id'];
                    $data['name'] = $result['description'];
                    $data['sale_price'] = $result['sale_price'];
                    $data['quantity'] = $product['quantity'];
                    $subTotal = $result['sale_price'] * $product['quantity'];
                    array_push($array['products'], $data);
                    $subTotalPrice += $subTotal;

                }
                if ($discount != null || $discount != 0) {
                    $discountAmount = ($subTotalPrice * ($discount / 100));
                    $priceSubtotal = $subTotalPrice - $discountAmount;
                } else {
                    $priceSubtotal = $subTotalPrice;
                }
                $tps = $priceSubtotal * 0.05;
                $tvq = $priceSubtotal * 0.09975;
                $totalPrice = $priceSubtotal + $tps + $tvq;

                $productData = json_encode($array['products']);
                $quote = $this->model->regQuoteOrder(
                    $productData,
                    $priceSubtotal,
                    $totalPrice,
                    $tps,
                    $tvq,
                    $currentDate,
                    $currentTime,
                    $payMethod,
                    $quoteValidate,
                    $discount,
                    $discountAmount,
                    $idClient,
                    $this->idUser
                );
                if ($quote > 0) {
                    $res = array('msg' => 'QUOTE GENERATED', 'type' => 'success', 'idQuote' => $quote);
                } else {
                    $res = array('msg' => 'QUOTE NOT GENERATED', 'type' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'EMPTY CART', 'type' => 'warning');
        }
        echo json_encode($res);
        die();
    }
    public function listQuotes()
    {
        $data = $this->model->getRecordQuotes();

        for ($i=0; $i < count($data); $i++) {
            $data[$i]['actions'] =  '<div>
            <a class="btn btn-danger" href="#" onclick="showReport(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

}