<?php

class Categories extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Categories';
        $data['script'] = 'categories.js';
        $this->views->getView('categories', 'index', $data);
    }
    public function listCategories()
    {
        $data = $this->model->getCategories(1);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteCategory(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editCategory(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function registerCategories()
    {
        if (isset($_POST['categoryName'])) {
            $id = strClean($_POST['idCategory']);
            $categoryName = strClean($_POST['categoryName']);
    
            if (empty($categoryName)) {
                $res = array('msg' => 'CATEGORY NAME IS REQUIRED', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $verifyCategory = $this->model->getCategoryValidate('category', $categoryName, 'register', 0);
                    if (empty($verifyCategory)) {
                        $data = $this->model->regCategory($categoryName);
                        if ($data > 0) {
                            $res = array('msg' => 'CATEGORY REGISTERED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'CATEGORY WAS NOT REGISTERED', 'type' => 'error');
                        }
                    } else {
                        $res = array('msg' => 'CATEGORY ALREADY EXIST', 'type' => 'warning');
                    }
                } else {
                    $verifyCategory = $this->model->getCategoryValidate('category', $categoryName, 'update', $id);
                    if (empty($verifyCategory)) {
                        $data = $this->model->modCategory($categoryName, $id);
                        if ($data > 0) {
                            $res = array('msg' => 'CATEGORY UPDATED', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'CATEGORY WAS NOT UPDATED', 'type' => 'error');
                        }
                    } else {
                        $res = array('msg' => 'CATEGORY ALREADY EXIST', 'type' => 'warning');
                    }
                }
            }

        } else {
            $res = array('msg' => 'CATEGORY WAS NOT UPDATED', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
        

    }
    public function delCategory($idCategory)
    {
        if (isset($_GET)) {
            if (is_numeric($idCategory)) {
                $data = $this->model->eraseCategory(0, $idCategory);
                if ($data > 0) {
                    $res = array('msg' => 'CATEGORY DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CATEGORY WAS NOT DELETED', 'type' => 'error');
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
    public function modifyCategories($idCategory)
    {
        $data = $this->model->updateCategory($idCategory);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function inactiveCategory()
    {
        $data['title'] = 'Inactive Categories';
        $data['script'] = 'categoryIncative.js';
        $this->views->getView('categories', 'inactCategories', $data);
    }
    public function listInactiveCategories()
    {
        $data = $this->model->getCategories(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreCategory(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>
          </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function categoryRestore($idCategory)
    {
        if (isset($_GET)) {
            if (is_numeric($idCategory)) {
                $data = $this->model->eraseCategory(1, $idCategory);
                if ($data > 0) {
                    $res = array('msg' => 'CATEGORY RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CATEGORY WAS NOT RESTORED', 'type' => 'error');
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
}
?>

