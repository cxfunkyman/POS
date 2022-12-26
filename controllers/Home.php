<?php

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Login';

        $this->views->getView('principal', 'login', $data);
    }
    //validate login form
    public function validate()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if (empty($_POST['email'])) {
                $res = array('msg' => 'EMAIL REQUIRED', 'type' => 'warning');
            } else if (empty($_POST['password'])) {
                $res = array('msg' => 'PASSWORD REQUIRED', 'type' => 'warning');
            } else {
                $email = strClean($_POST['email']);
                $password = strClean($_POST['password']);
                $data = $this->model->getData($email);

                if (empty($data)) {
                    $res = array('msg' => 'EMAIL DOES NOT EXIST', 'type' => 'warning');
                } else {
                    if (password_verify($password, $data['password'])) {
                        $_SESSION['id_user'] = $data['id'];
                        $_SESSION['user_name'] = $data['first_name'];
                        $_SESSION['user_lname'] = $data['last_name'];
                        $_SESSION['user_email'] = $data['email'];
                        $res = array('msg' => 'PASSWORD IS CORRECT', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'INCORRECT PASSWORD', 'type' => 'warning');
                    }
                }
            }
        } else {
            $res = array('msg' => 'UNKNOWN ERROR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
