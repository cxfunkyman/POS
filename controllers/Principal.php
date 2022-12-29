<?php
//Load Composer's autoloader
require 'vendor/autoload.php';

//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Principal extends Controller
{

    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function forgot()
    {
        $data['title'] = 'Forgot Password';
        //$data['script'] = 'products.js';
        $this->views->getView('users', 'forgot', $data);
    }
    public function reset($token)
    {
        $data['title'] = 'Reset Password';
        $data['secureToken'] = $this->model->verifyToken($token);
        if ($data['secureToken']['token'] != $token || empty($token) || $data['secureToken']['token'] == null) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $data['script'] = 'reset.js';
        $this->views->getView('users', 'reset', $data);
    }
    public function emailSend($email)
    {
        $verifyEmail = $this->model->verifyEmail($email);

        if (empty($verifyEmail)) {
            $res = array('msg' => 'EMAIL IS NOT REGISTERED, TRY AGAIN', 'type' => 'warning');
        } else {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            $date = date('YmdHis');
            $token = md5($date . $email);

            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->SMTPDebug = 0; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host       = HOST_SMTP; //Set the SMTP server to send through
                $mail->SMTPAuth   = true; //Enable SMTP authentication
                $mail->Username   = USER_SMTP; //SMTP username
                $mail->Password   = CODE_SMTP; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                $mail->Port       = PORT_SMTP; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom(USER_SMTP, 'KAZ corp');
                $mail->addAddress($email); //Add a recipient
                // $mail->addAddress('ellen@example.com'); //Name is optional
                // $mail->addReplyTo('info@example.com', 'Information');
                // $mail->addCC('cc@example.com');
                // $mail->addBCC('bcc@example.com');

                //Attachments
                // $mail->addAttachment('/var/tmp/file.tar.gz'); //Add attachments
                // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); //Optional name

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Password Reset';
                $mail->Body    = 'As you have requested for reset password instructions, here they are, please follow the URL: <br />
                <a href="' . BASE_URL . 'principal/reset/' . $token . '"><strong>CLICK HERE</strong></a>';
                // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

                $addToken = $this->model->regToken($token, $email);

                if ($addToken > 0) {
                    $res = array('msg' => 'MESSAGE HAS BEEN SENT', 'type' => 'success');
                } else {
                    $res = array('msg' => 'COULD NOT REGISTER TOKEN, TRY AGAIN LATER', 'type' => 'error');
                }
            } catch (Exception $e) {
                $res = array('msg' => 'MESSAGE COULD NOT BE SENT. MAILER REPORT: ' . $mail->ErrorInfo, 'type' => 'error');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function resetPassword()
    {
        $jason = file_get_contents('php://input');
        $pass = json_decode($jason, true);
        $newPass = strClean($pass['newPass']);
        $confirmPass = strClean($pass['confirmPass']);
        $resetToken = strClean($pass['resetToken']);

        if (empty($newPass)) {
            $res = array('msg' => 'NEW PASSWORD REQUIRED', 'type' => 'warning');
        } else if (empty($confirmPass)) {
            $res = array('msg' => 'CONFIRM PASSWORD REQUIRED', 'type' => 'warning');
        } else if ($newPass != $confirmPass) {
            $res = array('msg' => 'NEW PASSWORD AND CONFIRM PASSWORD MUST BE THE SAME', 'type' => 'warning');
        } else {
            $hash = password_hash($newPass, PASSWORD_DEFAULT);
            //$verifyPass = $this->model->verifyPassword($hash);
            $oldpass = $this->model->oldPass($resetToken);
            //print_r($oldpass);

            if (password_verify($oldpass['password'], $hash)) {
                $res = array('msg' => 'PASSWORD ALREADY EXIST, TRY ANOTHER ONE', 'type' => 'warning');
            } else {
                $data = $this->model->updatePassword($hash, $resetToken);
    
                if ($data > 0) {
                    $data = $this->model->updateToken($hash);
                    $res = array('msg' => 'PASSWORD UPDATED SUCCESSFULLY', 'type' => 'success');
                } else {
                    $res = array('msg' => 'PASSWORD COULD NOT BE UPDATED', 'type' => 'error');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function errorNotFound()
    {
        if (empty($_SESSION['id_user'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $data['title'] = 'Page Not Found';
        $this->views->getView('admin', 'notFound', $data);
    }
}
