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
    }
    public function forgot()
    {
        //$data['title'] = 'Forgot Password';
        //$data['script'] = 'products.js';
        $this->views->getView('users', 'forgot');
    }
    public function reset()
    {
        //$data['title'] = 'Reset Password';
        //$data['script'] = 'products.js';
        $this->views->getView('users', 'reset');
    }
    public function emailSend($email)
    {
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
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;//Enable implicit TLS encryption
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
            ' . $token;
           // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
