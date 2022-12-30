<?php
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;

class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'Products';
        $data['script'] = 'products.js';
        $data['measure'] = $this->model->getProductData('measures');
        $data['category'] = $this->model->getProductData('categories');
        $this->views->getView('products', 'index', $data);
    }
    public function listProducts()
    {
        $data = $this->model->getProducts(1);

        for ($i = 0; $i < count($data); $i++) {
            $photo = ($data[$i]['photo'] == null || !file_exists($data[$i]['photo'])) ? 'assets/images/products/default.jpg' : $data[$i]['photo'] ;
            $data[$i]['photo'] = '<img class="img-thumbnail" src="' . $photo . '" alt="Photo goes here" width="100">';
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteProduct(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editProduct(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerProducts()
    {
        if (isset($_POST['p_Description']) && isset($_POST['p_Code'])) {
            $id = strClean($_POST['idProduct']);
            $p_Code = strClean($_POST['p_Code']);
            $p_Description = strClean($_POST['p_Description']);
            $p_Price = strClean($_POST['p_Price']);
            $s_Price = strClean($_POST['s_Price']);
            $p_Measure = strClean($_POST['p_Measure']);
            $p_Category = strClean($_POST['p_Category']);

            $p_Photo = $_FILES['p_Photo'];
            $actualPhoto = strClean($_POST['actualPhoto']);
            $namePhoto = $p_Photo['name'];
            $tmpPhoto = $p_Photo['tmp_name'];

            $photoDirectory = null;
            if (!empty($namePhoto)) {
                $p_Date = date('YmdHis');
                $photoDirectory = 'assets/images/products/' . $p_Date . '.jpg';
            } else if (!empty($actualPhoto) && empty($namePhoto)) {
                $photoDirectory = $actualPhoto;
            }
            if (empty($p_Code)) {
                $res = array('msg' => 'CODE REQUIRED', 'type' => 'warning');
            } else if (empty($p_Description)) {
                $res = array('msg' => 'NAME REQUIRED', 'type' => 'warning');
            } else if (empty($p_Price)) {
                $res = array('msg' => 'PURCHASE PRICE REQUIRED', 'type' => 'warning');
            } else if (empty($s_Price)) {
                $res = array('msg' => 'SALE PRICE REQUIRED', 'type' => 'warning');
            } else if (empty($p_Measure)) {
                $res = array('msg' => 'MEASURE REQUIRED', 'type' => 'warning');
            } else if (empty($p_Category)) {
                $res = array('msg' => 'CATEGORY REQUIRED', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $verifyCode = $this->model->getProductValidate('code', $p_Code, 'register', 0);
                    $verifyName = $this->model->getProductValidate('description', $p_Description, 'register', 0);

                    if (!empty($verifyCode)) {
                        $res = array('msg' => 'CODE MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'PRODUCT NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else {
                        $data = $this->model->regProduct(
                            $p_Code,
                            $p_Description,
                            $p_Price,
                            $s_Price,
                            $p_Measure,
                            $p_Category,
                            $photoDirectory
                        );
                        if ($data > 0) {
                            if (!empty($namePhoto)) {
                                move_uploaded_file($tmpPhoto, $photoDirectory);
                            }
                            $res = array('msg' => 'PRODUCT REGISTERED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'PRODUCT WAS NOT REGISTERED', 'type' => 'error');
                        }
                    }
                } else {
                    $verifyCode = $this->model->getProductValidate('code', $p_Code, 'update', $id);
                    $verifyName = $this->model->getProductValidate('description', $p_Description, 'update', $id);

                    if (!empty($verifyCode)) {
                        $res = array('msg' => 'CODE MUST BE UNIQUE', 'type' => 'warning');
                    } else if (!empty($verifyName)) {
                        $res = array('msg' => 'PRODUCT NAME MUST BE UNIQUE', 'type' => 'warning');
                    } else {
                        $data = $this->model->modProduct(
                            $p_Code,
                            $p_Description,
                            $p_Price,
                            $s_Price,
                            $p_Measure,
                            $p_Category,
                            $photoDirectory,
                            $id
                        );
                        if ($data > 0) {
                            if (!empty($namePhoto)) {
                                move_uploaded_file($tmpPhoto, $photoDirectory);
                            }
                            $res = array('msg' => 'PRODUCT UPDATED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'PRODUCT WAS NOT UPDATED', 'type' => 'error');
                        }
                    }
                }
            }
        } else {
            $res = array('msg' => 'ERROR, PRODUCT WAS NOT REGISTERED', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function delProduct($idProduct)
    {
        if (isset($_GET)) {
            if (is_numeric($idProduct)) {
                $data = $this->model->eraseProduct(0, $idProduct);
                if ($data > 0) {
                    $res = array('msg' => 'PRODUCT DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'PRODUCT WAS NOT DELETED', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function modifyProducts($idProduct)
    {
        $data = $this->model->updateProduct($idProduct);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactiveProduct()
    {
        $data['title'] = 'Inactive Products';
        $data['script'] = 'productIncative.js';
        $this->views->getView('Products', 'inactProducts', $data);
    }
    public function listInactiveProducts()
    {
        $data = $this->model->getProducts(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreProduct(' . $data[$i]['id'] . ')"><i class="fa fa-check-circle"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function productRestore($idProducts)
    {
        if (isset($_GET)) {
            if (is_numeric($idProducts)) {
                $data = $this->model->eraseProduct(1, $idProducts);
                if ($data > 0) {
                    $res = array('msg' => 'PRODUCTS RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'PRODUCTS WAS NOT RESTORED', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    //function for searching by barcode from purchases.js
    public function searchByBarcode($value)
    {
        $array = array('status' => false, 'data' => '');
        $data = $this->model->searchBarcode($value);
        if (!empty($data)) {
            $array['status'] = true;
            $array['data'] = $data;
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
    //function for searching by product name from purchases.js
    public function searchByName()
    {
        $array = array();
        $value = $_GET['term'];
        $data = $this->model->searchPName($value);

        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['description'];
            $result['stock'] = $row['quantity'];
            $result['sale_price'] = $row['sale_price'];
            $result['purchase_price'] = $row['purchase_price'];
            array_push($array, $result);
        }

        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
    //function for loading data from localStorage to purchase table
    public function tblShowData()
    {
        $json = file_get_contents('php://input');
        $dataProducts = json_decode($json, true);
        $totalPricePurchase = 0;
        $totalPriceSale = 0;
        $array['products'] = array();

        if (!empty($dataProducts)) {
            foreach ($dataProducts as $product) {

                $result = $this->model->updateProduct($product['id']);
                $data['id'] = $result['id'];
                $data['name'] = $result['description'];
                // $data['purchase_price'] = $product['purchase_price'];
                // $data['sale_price'] = $product['sale_price'];
                $data['purchase_price'] = number_format(((empty($product['price'])) ? 0 : $product['price']), 2, '.', '');
                $data['sale_price'] = number_format(((empty($product['price'])) ? 0 : $product['price']), 2, '.', '');
                $data['quantity'] = $product['quantity'];
                $subTotalPurchase = $data['purchase_price'] * $product['quantity'];
                $subTotalSale = $data['sale_price'] * $product['quantity'];
                $data['subTotalPurchase'] = number_format($subTotalPurchase, 2);
                $data['subTotalSale'] = number_format($subTotalSale, 2);
                array_push($array['products'], $data);
                $totalPricePurchase += $subTotalPurchase;
                $totalPriceSale += $subTotalSale;
            }
        }

        $array['totalPurchase'] = number_format($totalPricePurchase, 2);
        $array['totalSale'] = number_format($totalPriceSale, 2);
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }
    //PDF & Excel Reports for active/inactive Products in Stock
    public function activeProductPDF()
    {
        $this->productPDFReport(1);
    }
    public function inactiveProductPDF()
    {
        $this->productPDFReport(0);
    }
    public function productPDFReport($status)
    {
        ob_start();

        $data['title'] = ($status == 1) ? 'Active Products Report' : 'Inactive Products Report';
        $data['companies'] = $this->model->getCompanies();
        $data['products'] = $this->model->getProducts($status);

        $this->views->getView('reports', 'active_inactiveProductPDF', $data);
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
        $dompdf->stream(($status == 1) ? 'activeProductReport.pdf' : 'inactiveProductReport.pdf', array('Attachment' => false));
    }
    public function activeProductExcel()
    {
        $this->productExcelReport(1);
    }
    public function inactiveProductExcel()
    {
        $this->productExcelReport(0);
    }
    public function productExcelReport($status)
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator($_SESSION['user_name'] . ' ' . $_SESSION['user_lname'])
            ->setTitle(($status == 1) ? "Active Product Report" : "Inactive Product Report")
            ->setSubject(($status == 1) ? "Active Product Report" : "Inactive Product Report")
            ->setDescription(($status == 1) ? "Report to show the active products in store." : "Report to show the inactive products in store.");

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);



        $activeSheet = $spreadsheet->getActiveSheet();
        if ($status == 1) {
            $activeSheet->setTitle('Active Product Report');
        } else {
            $activeSheet->setTitle('Inactive Product Report');
        }
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(12);
        $activeSheet->getColumnDimension('F')->setWidth(12);
        $activeSheet->getColumnDimension('G')->setWidth(30);
        $activeSheet->getColumnDimension('H')->setWidth(30);

        $activeSheet->setCellValue('A1', 'Code');
        $activeSheet->setCellValue('B1', 'Product');
        $activeSheet->setCellValue('C1', 'Purchase Price');
        $activeSheet->setCellValue('D1', 'Sale Price');
        $activeSheet->setCellValue('E1', 'Quantity');
        $activeSheet->setCellValue('F1', 'Sales');
        $activeSheet->setCellValue('G1', 'Measure');
        $activeSheet->setCellValue('H1', 'Category');

        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF00C8FA');
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $eRow = 2;
        $data['products'] = $this->model->getProducts($status);

        foreach ($data['products'] as $product) {
            if (fmod($eRow, 2) != 0) {
                $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':H' . $eRow)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE9E9E9');
            }
            $spreadsheet->getActiveSheet()->getStyle('C' . $eRow . ':D' . $eRow)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':H' . $eRow)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $activeSheet->setCellValue('A' . $eRow, $product['code']);
            $activeSheet->setCellValue('B' . $eRow, $product['description']);
            $activeSheet->setCellValue('C' . $eRow, $product['purchase_price']);
            $activeSheet->setCellValue('D' . $eRow, $product['sale_price']);
            $activeSheet->setCellValue('E' . $eRow, $product['quantity']);
            $activeSheet->setCellValue('F' . $eRow, $product['sales']);
            $activeSheet->setCellValue('G' . $eRow, $product['measure']);
            $activeSheet->setCellValue('H' . $eRow, $product['category']);
            $eRow++;
        }
        $date = date('Y-m-d-H:i:s');
        //Generate an excel file download
        header('Content-Type: application/vnd.ms-excel');
        header(($status == 1) ? 'Content-Disposition: attachment;filename="activeProducts-' . $date . '.xlsx"' : 'Content-Disposition: attachment;filename="inactiveProducts-' . $date . '.xlsx"');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    //Barcode products
    public function generateBarcode()
    {
        $status = 1;
        // $generator = new BarcodeGeneratorHTML();
        // echo $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);
        $route = 'assets/images/barcode/';

        $datas['products'] = $this->model->getProducts($status);
        $generator = new BarcodeGeneratorPNG();

        foreach ($datas['products'] as $product) {
            if (!file_exists($route . $product['id'] . '.png')) {
                file_put_contents($route . $product['id'] . '.png', $generator->getBarcode($product['code'], $generator::TYPE_CODE_128, 3, 50));
                
                $this->model->barcodeProduct($product['id'], $route . $product['id'] . '.png', $status);
            }
        }
        ob_start();

        $data['title'] = ($status == 1) ? 'Active Products Barcode' : 'Inactive Products Barcode';
        $data['products'] = $this->model->getProducts($status);

        $this->views->getView('reports', 'barcode', $data);
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
        $dompdf->stream(($status == 1) ? 'activeProductBarcode.pdf' : 'inactiveProductBarcode.pdf', array('Attachment' => false));
    }
}
