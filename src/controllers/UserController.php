<?php

namespace mygiftbox\controllers;

use mygiftbox\mailer\ServerMailer;

use mygiftbox\models\User;

use mygiftbox\views\LoginView;
use mygiftbox\views\RegisterView;
use mygiftbox\views\ForgotPasswordView;


class UserController{

    public function getLogin(){
        $v = new LoginView();
        $v->render();
    }

    public function getRegister(){
        $v = new RegisterView();
        $v->render();
    }

    public function getLogout(){
        $app = \Slim\Slim::getInstance();
        session_destroy();
        $app->redirect($app->urlFor('home'));
    }

    public function getForgotPassword(){
        $v = new ForgotPasswordView();
        $v->render();
    }

    public function postForgotPassword(){
        $app = \Slim\Slim::getInstance();
        $mailer = new ServerMailer($app);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if (!empty($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if(User::exists($email)){
                    $user = User::byMail($email);
                    $newpass = bin2hex(\openssl_random_pseudo_bytes(22));
                    $options = [
                        0 => password_hash($user->password, PASSWORD_BCRYPT),
                        1 => $newpass
                    ];
                    if($mailer->sendMail($email, $options, 'forgot_pass')){
                        $_SESSION['temp'] = \password_hash($newpass, PASSWORD_BCRYPT);
                    }  
                }
            }
        } 
        $app->redirect($app->urlFor('forgotpass'));
    }

    public function getUserLinkClicked(){
        $app = \Slim\Slim::getInstance();
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
        $user = User::byMail($email);
        if(isset($user) && $_SESSION['temp']){
            if(password_verify($user->password, $_GET['hash'])){
                $user->password = $_SESSION['temp'];
                $user->save();    
            } 
            
        }
        $app->redirect($app->urlFor('login'));
    }

}