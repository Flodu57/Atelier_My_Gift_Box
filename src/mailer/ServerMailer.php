<?php

namespace mygiftbox\mailer;

require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use mygiftbox\mailer\presets\ForgotPasswordMail;
use mygiftbox\mailer\presets\RegisterMail;

class ServerMailer
{

    public function __construct($app)
    {
        $this->app = $app;
        $this->mail = new PHPMailer;
        $this->mail->isSMTP();
//Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $this->mail->SMTPDebug = 0;
        $this->mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ),
        );
        $this->mail->Host = 'smtp-mail.outlook.com';
        $this->mail->Port = 587;
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'atelier_mygiftbox@outlook.fr';
        $this->mail->Password = 'mygiftbox0';
        $this->mail->setFrom('atelier_mygiftbox@outlook.fr', 'Mygiftbox');  
        $this->mail->CharSet='UTF-8';   
    }

    public function sendMail($target, $options, $case)
    {
        $content = "";
        switch($case){
            case 'register' :
                $this->mail->Subject = 'Activez votre compte MyGiftBox !';  
                $content = RegisterMail::Mail($this->app, $target, $options);
                break;  
            case 'forgot_pass' :
                $this->mail->Subject = 'Récupération de mot de passe';
                $content = ForgotPasswordMail::Mail($this->app, $target, $options);
                break;
            default :
                return false;
        }
        $this->mail->msgHtml($content);   
        //Set who the message is to be sent to
        $this->mail->addAddress($target);
        if (!$this->mail->send()) {
            //echo 'Mailer Error: ' . $this->mail->ErrorInfo;
            return false;
        } else {
            //echo 'Message sent!';
            return true;
        }
    }

}