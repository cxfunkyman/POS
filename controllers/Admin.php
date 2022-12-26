<?php
require 'vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class Admin extends Controller
{
    private $idUser;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->idUser = $_SESSION['id_user'];
        $this->userName = $_SESSION['user_name'] . ' ' . $_SESSION['user_lname'];
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
        $data['topProducts'] = $this->model->topProducts(5);
        $data['newProducts'] = $this->model->newProducts(10);
        $data['minimumStock'] = $this->model->stockMinimum(5);
        $this->views->getView('admin', 'home', $data);
    }
    // Company data
    public function configData()
    {
        $data['title'] = 'Company data';
        $data['script'] = 'configData.js'; // the script of the page is assigned to the array
        $data['company'] = $this->model->getCompanies();
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
        $data = $this->model->topProducts(5);
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
        $data = $this->model->stockMinimum(5);
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
    //PDF & Excel reports for top sales products
    public function topProductPDF()
    {
        ob_start();

        $data['title'] = 'Top Products Report';
        $data['companies'] = $this->model->getCompanies();
        $data['products'] = $this->model->topProducts(50);

        $this->views->getView('reports', 'topProductPDF', $data);
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
        $dompdf->stream('topProductReport.pdf', array('Attachment' => false));
    }
    public function topProductExcel()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator($_SESSION['user_name'] . ' ' . $_SESSION['user_lname'])
            ->setTitle("Top Product Sale Report")
            ->setSubject("Top Product Report")
            ->setDescription("Report to show the products with most sales in the store.");

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);

        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Top Product Report');
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(12);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(12);
        $activeSheet->getColumnDimension('G')->setWidth(30);

        $activeSheet->setCellValue('A1', 'Code');
        $activeSheet->setCellValue('B1', 'Product');
        $activeSheet->setCellValue('C1', 'Quantity');
        $activeSheet->setCellValue('D1', 'Purchase Price');
        $activeSheet->setCellValue('E1', 'Sale Price');
        $activeSheet->setCellValue('F1', 'Qty Sold');
        $activeSheet->setCellValue('G1', 'Category');

        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF00C8FA');
        $spreadsheet->getActiveSheet()->getStyle('A1:G1')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $eRow = 2;
        $data['products'] = $this->model->topProducts(50);

        foreach ($data['products'] as $product) {
            if (fmod($eRow, 2) != 0) {
                $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':G' . $eRow)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE9E9E9');
            }
            $spreadsheet->getActiveSheet()->getStyle('D' . $eRow . ':E' . $eRow)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':G' . $eRow)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $activeSheet->setCellValue('A' . $eRow, $product['code']);
            $activeSheet->setCellValue('B' . $eRow, $product['description']);
            $activeSheet->setCellValue('C' . $eRow, $product['quantity']);
            $activeSheet->setCellValue('D' . $eRow, $product['purchase_price']);
            $activeSheet->setCellValue('E' . $eRow, $product['sale_price']);
            $activeSheet->setCellValue('F' . $eRow, $product['sales']);
            $activeSheet->setCellValue('G' . $eRow, $product['category']);
            $eRow++;
        }


        $date = date('Y-m-d-H:i:s');
        //Generate an excel file download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="topProducts-' . $date . '.xlsx"');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    //PDF & Excel Reports for Products with Minimum Stock
    public function minProdStockPDF()
    {
        ob_start();

        $data['title'] = 'Products Wtih Minimum Stock Report';
        $data['companies'] = $this->model->getCompanies();
        $data['products'] = $this->model->stockMinimum(50);

        $this->views->getView('reports', 'minimumStockPDF', $data);
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
        $dompdf->stream('minimumStockReport.pdf', array('Attachment' => false));
    }
    public function minProdStockExcel()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator($_SESSION['user_name'] . ' ' . $_SESSION['user_lname'])
            ->setTitle("Minimum Product In Stock Report")
            ->setSubject("Minimum Stock Product Report")
            ->setDescription("Report to show the products with minimum stock in the store.");

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);

        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Minimum Product Stock Report');
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(12);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(20);
        $activeSheet->getColumnDimension('F')->setWidth(30);

        $activeSheet->setCellValue('A1', 'Code');
        $activeSheet->setCellValue('B1', 'Product');
        $activeSheet->setCellValue('C1', 'Stock');
        $activeSheet->setCellValue('D1', 'Purchase Price');
        $activeSheet->setCellValue('E1', 'Sale Price');
        $activeSheet->setCellValue('F1', 'Category');

        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF00C8FA');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $eRow = 2;
        $data['products'] = $this->model->stockMinimum(50);

        foreach ($data['products'] as $product) {
            if (fmod($eRow, 2) != 0) {
                $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':F' . $eRow)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE9E9E9');
            }
            $spreadsheet->getActiveSheet()->getStyle('D' . $eRow . ':E' . $eRow)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':F' . $eRow)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

            $activeSheet->setCellValue('A' . $eRow, $product['code']);
            $activeSheet->setCellValue('B' . $eRow, $product['description']);
            $activeSheet->setCellValue('C' . $eRow, $product['quantity']);
            $activeSheet->setCellValue('D' . $eRow, $product['purchase_price']);
            $activeSheet->setCellValue('E' . $eRow, $product['sale_price']);
            $activeSheet->setCellValue('F' . $eRow, $product['category']);
            $eRow++;
        }

        $date = date('Y-m-d-H:i:s');
        //Generate an excel file download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="minimumStockProduct-' . $date . '.xlsx"');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
    //PDF & Excel Reports for Recent Products in Stock
    public function recentProductPDF()
    {
        ob_start();

        $data['title'] = 'Products With Minimum Stock Report';
        $data['companies'] = $this->model->getCompanies();
        $data['products'] = $this->model->newProducts(50);

        $this->views->getView('reports', 'recentProductStockPDF', $data);
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
        $dompdf->stream('recentProductReport.pdf', array('Attachment' => false));
    }
    public function recentProductExcel()
    {
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()
            ->setCreator($_SESSION['user_name'] . ' ' . $_SESSION['user_lname'])
            ->setTitle("Recent Product In Stock Report")
            ->setSubject("Recent Stock Product Report")
            ->setDescription("Report to show the Recent products on stock in the store.");

        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(12);

        $activeSheet = $spreadsheet->getActiveSheet();
        $activeSheet->setTitle('Recent Product Stock Report');
        $activeSheet->getColumnDimension('A')->setWidth(15);
        $activeSheet->getColumnDimension('B')->setWidth(50);
        $activeSheet->getColumnDimension('C')->setWidth(20);
        $activeSheet->getColumnDimension('D')->setWidth(20);
        $activeSheet->getColumnDimension('E')->setWidth(22);
        $activeSheet->getColumnDimension('F')->setWidth(30);

        $activeSheet->setCellValue('A1', 'Code');
        $activeSheet->setCellValue('B1', 'Product');
        $activeSheet->setCellValue('C1', 'Purchase Price');
        $activeSheet->setCellValue('D1', 'Sale Price');
        $activeSheet->setCellValue('E1', 'Date');
        $activeSheet->setCellValue('F1', 'Category');

        $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF00C8FA');
        $spreadsheet->getActiveSheet()->getStyle('A1:F1')
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $eRow = 2;
        $data['products'] = $this->model->newProducts(50);

        foreach ($data['products'] as $product) {
            if (fmod($eRow, 2) != 0) {
                $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':F' . $eRow)->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFE9E9E9');
            }
            $spreadsheet->getActiveSheet()->getStyle('C' . $eRow . ':D' . $eRow)->getNumberFormat()
                ->setFormatCode('#,##0.00');
            $spreadsheet->getActiveSheet()->getStyle('A' . $eRow . ':F' . $eRow)
                ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A' . $eRow)
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('E' . $eRow)
                ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $activeSheet->setCellValue('A' . $eRow, $product['code']);
            $activeSheet->setCellValue('B' . $eRow, $product['description']);
            $activeSheet->setCellValue('C' . $eRow, $product['purchase_price']);
            $activeSheet->setCellValue('D' . $eRow, $product['sale_price']);
            $activeSheet->setCellValue('E' . $eRow, $product['dates']);
            $activeSheet->setCellValue('F' . $eRow, $product['category']);
            $eRow++;
        }

        $date = date('Y-m-d_H-i-s');
        //Generate an excel file download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="recentStockProduct-' . $date . '.xlsx"');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
