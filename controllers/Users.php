<?php

class Users extends Controller
{
    private $idUser;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->idUser = $_SESSION['id_user'];
    }
    public function index()
    {
        $data['title'] = 'Users';
        $data['script'] = 'users.js';
        $this->views->getView('users', 'index', $data);
    }
    //Method to show the selected user
    public function listUsers()
    {
        $data = $this->model->getUsers(1);
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMIN</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">SALESPERSON</span>';
            }

            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="deleteUser(' . $data[$i]['id'] . ')"><i class="fa fa-trash"></i></button>
            <button class="btn btn-info" type="button" onclick="editUser(' . $data[$i]['id'] . ')"><i class="fas fa-user-edit"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Method to signUp and modify users
    public function signUp()
    {
        if (isset($_POST)) {
            if (empty($_POST['fName'])) {
                $res = array('msg' => 'FIRST NAME REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['lName'])) {
                $res = array('msg' => 'LAST NAME REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['email'])) {
                $res = array('msg' => 'EMAIL REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['phone'])) {
                $res = array('msg' => 'PHONE NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['address'])) {
                $res = array('msg' => 'ADDRESS REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['password'])) {
                $res = array('msg' => 'PASSWORD REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['rol'])) {
                $res = array('msg' => 'ROL REQUIRED', 'type' => 'warning');
            } else {
                $fName = strClean($_POST['fName']);
                $lName = strClean($_POST['lName']);
                $email = strClean($_POST['email']);
                $phone = strClean($_POST['phone']);
                $address = strClean($_POST['address']);
                $password = strClean($_POST['password']);
                $rol = strClean($_POST['rol']);
                $id = strClean($_POST['idUser']);

                if ($id == '') {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    //Verify if the data exist already  
                    $verifyEmail = $this->model->getValidate('email', $email, 'register', 0);

                    if (empty($verifyEmail)) {
                        $verifyPhone = $this->model->getValidate('phone_number', $phone, 'register', 0);
                        if (empty($verifyPhone)) {
                            $data = $this->model->signUpUsers(
                                $fName,
                                $lName,
                                $email,
                                $phone,
                                $address,
                                $hash,
                                $rol
                            );
                            if ($data > 0) {
                                $res = array('msg' => 'USER REGISTERED', 'type' => 'success');
                            } else {
                                $res = array('msg' => 'ERROR, USER NOT REGISTERED', 'type' => 'error');
                            }
                        } else {
                            $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                    }
                } else {
                    //Verify if the data exist already
                    $verifyEmail = $this->model->getValidate('email', $email, 'update', $id);

                    if (empty($verifyEmail)) {
                        $verifyPhone = $this->model->getValidate('phone_number', $phone, 'update', $id);
                        if (empty($verifyPhone)) {
                            $data = $this->model->userUpdate(
                                $fName,
                                $lName,
                                $email,
                                $phone,
                                $address,
                                $rol,
                                $id
                            );
                            if ($data > 0) {
                                $res = array('msg' => 'USER UPDATED', 'type' => 'success');
                            } else {
                                $res = array('msg' => 'ERROR, USER NOT UPDATED', 'type' => 'error');
                            }
                        } else {
                            $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                    }
                }
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Method to delete users
    public function delUsers($id)
    {
        if (isset($_GET)) {
            if (is_numeric($id)) {
                $data = $this->model->delete(0, $id);
                if ($data == 1) {
                    $res = array('msg' => 'USER DELETED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CAN NOT DELETE ERROR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR CX', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Method edit\recover users
    public function editedUser($id)
    {
        $data = $this->model->userEdit($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //Method to view inactive users
    public function inactive()
    {
        $data['title'] = 'Inactive Users';
        $data['script'] = 'inactive_users.js';
        $this->views->getView('users', 'inactive', $data);
    }
    public function listInactiveUsers()
    {
        $data = $this->model->getUsers(0);
        for ($i = 0; $i < count($data); $i++) {

            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMIN</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">SALESPERSON</span>';
            }

            $data[$i]['actions'] = '<div>
            <button class="btn btn-danger" type="button" onclick="restoreUser(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle"></i></button>            
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function userRestore($id)
    {
        if (isset($_GET)) {
            if (is_numeric($id)) {
                $data = $this->model->delete(1, $id);
                if ($data == 1) {
                    $res = array('msg' => 'USER RESTORED', 'type' => 'success');
                } else {
                    $res = array('msg' => 'CAN NOT RESTORE ERROR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR CX', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function profile()
    {
        $data['title'] = 'User Profile';
        $data['users'] = $this->model->userProfile($this->idUser);
        $data['script'] = 'profile.js';
        $this->views->getView('users', 'profile', $data);
    }
    public function updateProfile()
    {

        if (
            isset($_POST['fNameProfile']) && isset($_POST['lNameProfile']) && isset($_POST['emailProfile'])
            && isset($_POST['phoneProfile']) && isset($_POST['addressProfile']) && isset($_POST['oldPassProfile'])
            && isset($_POST['newPassProfile'])
        ) {
            $fName = strClean($_POST['fNameProfile']);
            $lName = strClean($_POST['lNameProfile']);
            $email = strClean($_POST['emailProfile']);
            $phone = strClean($_POST['phoneProfile']);
            $address = strClean($_POST['addressProfile']);
            $oldPass = $_POST['oldPassProfile'];
            $newPass = $_POST['newPassProfile'];

            $passHash = password_hash($newPass, PASSWORD_DEFAULT);

            $profilePhoto = $_FILES['profilePhoto'];
            $actualPhoto = strClean($_POST['actualPhoto']);
            $namePhoto = $profilePhoto['name'];
            $tmpPhoto = $profilePhoto['tmp_name'];

            $photoDirectory = null;
            if (!empty($namePhoto)) {
                $photoDate = $fName . '_' . $lName . '_' . date('YmdHis');
                $photoDirectory = 'assets/images/profile/' . $photoDate . '.jpg';
            } else if (!empty($actualPhoto) && empty($namePhoto)) {
                $photoDirectory = $actualPhoto;
            }
            if (empty($fName)) {
                $res = array('msg' => 'FIRST NAME REQUIRED', 'type' => 'warning');
            } else if (empty($lName)) {
                $res = array('msg' => 'LAST NAME REQUIRED', 'type' => 'warning');
            } else if (empty($email)) {
                $res = array('msg' => 'EMAIL REQUIRED', 'type' => 'warning');
            } else if (empty($phone)) {
                $res = array('msg' => 'PHONE NUMBER REQUIRED', 'type' => 'warning');
            } else if (empty($address)) {
                $res = array('msg' => 'ADDRESS REQUIRED', 'type' => 'warning');
            }
            else {
                $verifyEmail = $this->model->getprofileValidate('email', $email, $this->idUser);
                $verifyPhone = $this->model->getprofileValidate('phone_number', $phone, $this->idUser);
                $profile = $this->model->userProfile($this->idUser);

                if (empty($photoDirectory)) {
                    $photoDirectory = $profile['profile'];
                }
                if (empty($newPass)) {
                    $passHash = $profile['password'];
                } else if (!empty($newPass)) {
                    $verifyPass = $this->model->getpassValidate('password', $passHash, $this->idUser);
                    if (!empty($verifyPass)) {
                        $res = array('msg' => 'PASSWORD IS BEING USED', 'type' => 'warning');
                        echo json_encode($res, JSON_UNESCAPED_UNICODE);
                        die();
                    }
                }
                if (!empty($verifyEmail)) {
                    $res = array('msg' => 'EMAIL MUST BE UNIQUE', 'type' => 'warning');
                } else if (!empty($verifyPhone)) {
                    $res = array('msg' => 'PHONE NUMBER MUST BE UNIQUE', 'type' => 'warning');
                } else {
                    $data = $this->model->updateProfile(
                        $this->idUser,
                        $fName,
                        $lName,
                        $email,
                        $phone,
                        $address,
                        $photoDirectory,
                        $passHash
                    );
                    if ($data > 0) {
                        if (!empty($namePhoto)) {
                            move_uploaded_file($tmpPhoto, $photoDirectory);
                        }
                        if (empty($newPass)) {
                            $bool = false;
                        } else {
                            $bool = true;
                        }
                        
                        $res = array('msg' => 'PROFILE UPDATED', 'type' => 'success', 'password' => $bool);
                    } else {
                        $res = array('msg' => 'PROFILE WAS NOT UPDATED', 'type' => 'error');
                    }
                }
            }
        } else {
            $res = array('msg' => 'ERROR, PROFILE WAS NOT UPDATED', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function logout()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}
