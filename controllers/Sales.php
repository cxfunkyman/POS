<?php
require 'vendor/autoload.php';

//used for the process of printing sales on paper.
//reference https://github.com/mike42/escpos-php
//installed with Composer: composer require mike42/escpos-php
//refrence code use it to generate the print:
//https://parzibyte.me/blog/2017/09/10/imprimir-ticket-en-impresora-termica-php/
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

// reference the Dompdf namespace
use Dompdf\Dompdf;

class Sales extends Controller
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
        $data['title'] = 'Sales';
        $data['script'] = 'sales.js';
        $data['search'] = 'search.js';
        $data['cart'] = 'postSale';
        $resultSerie = $this->model->getSerie();
        $serie = ($resultSerie['serie'] == null) ? 1 : $resultSerie['serie'] + 1;
        $data['serie'] = $this->randomNumbers($serie, 1, 8);
        $this->views->getView('sales', 'index', $data);
    }
    public function registerSale()
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
            $discount = (!empty($dataSales['discount'])) ? $dataSales['discount'] : 0;
            $resultSerie = $this->model->getSerie();
            $numSerie = ($resultSerie['serie'] == null) ? 1 : $resultSerie['serie'] + 1;
            $serie = $this->randomNumbers($numSerie, 1, 8);
            $idClient = $dataSales['idClient'];

            if (empty($idClient)) {
                $res = array('msg' => 'CLIENT REQUIRED', 'type' => 'warning');
            } else if (empty($payMethod)) {
                $res = array('msg' => 'PAYMENT METHOD REQUIRED', 'type' => 'warning');
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
                $sale = $this->model->regSaleOrder(
                    $productData,
                    $priceSubtotal,
                    $totalPrice,
                    $tps,
                    $tvq,
                    $currentDate,
                    $currentTime,
                    $payMethod,
                    $discount,
                    $discountAmount,
                    $serie[0],
                    $idClient,
                    $this->idUser
                );
                if ($sale > 0) {
                    $actionSale = 'OUT PRODUCT';
                    foreach ($dataSales['products'] as $product) {
                        $result = $this->model->getSaleList($product['id']);
                        //update stock
                        $newQuantity = $result['quantity'] - $product['quantity'];
                        $this->model->updateQuantity($newQuantity, $product['id']);
                        //inventory movement
                        $movement = 'Sale N°: ' . $sale;
                        $quantity = -$product['quantity'];
                        $this->model->registerInvMovement($movement, $actionSale, $quantity, $currentDate, $currentTime, $result['code'], $result['photo'], $product['id'], $this->idUser);
                    }
                    if ($payMethod == 'CREDIT') {
                        $amountSale = $totalPrice;
                        $this->model->registerCredit($amountSale, $currentDate, $currentTime, $sale);
                    }
                    if ($dataSales['optionPrinter']) {
                        $this->paperPrint($sale);
                    }

                    $res = array('msg' => 'SALE GENERATED', 'type' => 'success', 'idSale' => $sale);
                } else {
                    $res = array('msg' => 'SALE WAS NOT GENERATED', 'type' => 'error');
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
        $idSales = $array[1];

        $data['title'] = 'Statements';
        $data['companies'] = $this->model->getCompanies();
        $data['sales'] = $this->model->getSales($idSales);
        if (empty($data['sales'])) {
            echo 'Page not Found';
            exit;
        }
        $this->views->getView('sales', $type, $data);
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
    function randomNumbers($start, $count, $digits)
    {
        $result = array();
        for ($i = $start; $i < $start + $count; $i++) {
            $result[] = str_pad($i, $digits, "0", STR_PAD_LEFT);
        }
        return $result;
    }
    public function listSales()
    {
        $data = $this->model->listRecords();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['status'] == 1) {
                $data[$i]['actions'] = '<div>
                <a class="btn btn-warning" href="#" onclick="deleteSale(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></a>
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
    public function cancelSale($idSale)
    {
        if (isset($_GET) && is_numeric($idSale)) {
            $data = $this->model->dropSaleOrder($idSale);
            if ($data > 0) {
                $currentDate = date('Y-m-d');
                $currentTime = date('H:i:s');
                $actionSale = 'IN PRODUCT';
                $resultSale = $this->model->getSales($idSale);
                $stockSale = json_decode($resultSale['products'], true);
                foreach ($stockSale as $product) {
                    $result = $this->model->getSaleList($product['id']);
                    //update stock
                    $newQuantity = $result['quantity'] + $product['quantity'];
                    $this->model->updateQuantity($newQuantity, $product['id']);
                    //inventory movement
                    $movement = 'Return Sale N°: ' . $idSale;
                    $this->model->registerInvMovement($movement, $actionSale, $product['quantity'], $currentDate, $currentTime, $result['code'], $result['photo'], $product['id'], $this->idUser);
                }
                if ($resultSale['pay_method'] == 'CREDIT') {
                    $this->model->cancelCredit($idSale);
                }
                $res = array('msg' => 'SALE ORDER CANCELLED', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR, SALE ORDER NOT CANCELLED', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'Unknown Error', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
    public function paperPrint($idSales)
    {
        /*
	    in this function let's try to print a logo, this is
	    optional. Thi might not work in every printer.
        The imahe is recomended not to be transparent, if is
        a .png image take out the alpha channel, low
        resolution, and 250X250 recommended size.
        */
        $company = $this->model->getCompanies();
        $sale = $this->model->getSales($idSales);

        $printerName = PRINTER;
        $connector = new WindowsPrintConnector($printerName);
        $printer = new Printer($connector);
        // center align next print
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        //load and print the logo
        try {
            $logo = EscposImage::load("assets/images/logo-img.png", false);
            $printer->bitImage($logo);
        } catch (Exception $e) { //Do nothing in case of an error
        }
        //print the header
        //Company info
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text($company['name'] . "\n");
        $printer->text('Tax ID: ' . $company['taxID'] . "\n");
        $printer->text('phone: ' . $company['phone_number'] . "\n");
        $printer->text('Address: ' . $company['address'] . "\n\n");
        //print the date and time
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text(date("Y-m-d H:i:s") . "\n\n");
        //Client info
        $printer->text('Client information' . "\n");
        $printer->text('-----------------------' . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($sale['identification'] . ': ' . $sale['num_identity'] . "\n");
        $printer->text('Name: ' . $sale['name'] . "\n");
        $printer->text('phone: ' . $sale['phone_number'] . "\n");
        $printer->text('Address: ' . $sale['address'] . "\n\n");


        //print products and show the total
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('Sale datails' . "\n\n");

        $products = json_decode($sale['products'], true);
        foreach ($products as $product) {
            //Align left for QTY and name
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($product['quantity'] . "x" . $product['name'] . "\n");
            //Align right for the import
            $printer->setJustification(Printer::JUSTIFY_RIGHT);
            $printer->text(CURRENCY . number_format($product['sale_price'], 2) . "\n");
        }
        //finish printing the products, now the total
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n---------------\n\n");

        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        if ($sale['discount_amount'] != null || $sale['discount_amount'] != 0) {
            $printer->text("Discount: " . CURRENCY . number_format($sale['discount_amount'], 2) . "\n");
        }
        $printer->text("subtotal: " . CURRENCY . number_format($sale['subtotal'], 2) . "\n");
        $printer->text("TPS%: " . CURRENCY . number_format($sale['sale_tps'], 2) . "\n");
        $printer->text("TVQ%: " . CURRENCY . number_format($sale['sale_tvq'], 2) . "\n");
        $printer->text("TOTAL: " . CURRENCY . number_format($sale['total'], 2) . "\n\n");
        //Print a footer with a thanks message
        $printer->text($company['message']);
        //feed paper 3 times
        $printer->feed(3);
        //cut the paper. in case the printer doesn't have
        //a paper cutter, won't generate an error.
        $printer->cut();
        //in case the printer is connected to the
        // cash register, send a pulse to open it
        //or tu notify the state
        $printer->pulse();
        //close printer connection
        $printer->close();
    }
    public function verifyStock($idProduct)
    {
        $data = $this->model->getSaleList($idProduct);
        echo json_encode($data);
        die();
    }
}
