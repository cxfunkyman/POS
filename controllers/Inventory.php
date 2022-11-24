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
        ob_start();

        $data['companies'] = $this->model->getCompanies();
        
        if (empty($months)) {
            $data['inventory'] = $this->model->getInvMovement();
        } else {
            echo 'hello';
            $array = explode('-', $months);
            $year = $array[0];
            $month = $array[1];
            $data['inventory'] = $this->model->getMoveByMonth($year, $month);
        }
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
}
