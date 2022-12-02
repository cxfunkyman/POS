<?php

class Products extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
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
            $data[$i]['photo'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" alt="Photo goes here" width="100">';
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
            $data[$i]['photo'] = '<img class="img-thumbnail" src="' . $data[$i]['photo'] . '" alt="Photo goes here" width="100">';
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
        if (!empty($data)){
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
                $data['purchase_price'] = $result['purchase_price'];
                $data['sale_price'] = $result['sale_price'];
                $data['quantity'] = $product['quantity'];
                $subTotalPurchase = $result['purchase_price'] * $product['quantity'];
                $subTotalSale = $result['sale_price'] * $product['quantity'];
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
}
