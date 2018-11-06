<?php

namespace mygiftbox\controllers;

use mygiftbox\mailer\ServerMailer;
use mygiftbox\models\User;
use mygiftbox\views\ForgotPasswordView;
use mygiftbox\views\LoginView;
use mygiftbox\views\RegisterView;

class UserController{

    public function getLogin(){
        $v = new LoginView();
        $v->render();
    }

    public function postLogin(){
        $app = \Slim\Slim::getInstance();
        if(isset($_POST['email']) && isset($_POST['password'])){
            $mail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            if(!empty($mail) && !empty($password)){
                $user = User::where('email','=',$mail)->first();
                if($user){
                    if(password_verify($password, $user->password)){
                        $_SESSION['id_user'] = $user->id;
                    }else{
                        $app->flash('error', 'Mot de passe ou utilisateur incorrect');
                        $app->redirect('login');
                    }
                }else{
                    $app->flash('error', 'Mot de passe ou utilisateur incorrect');
                    $app->redirect('login');
                }
            } else {
                $app->flash('error', 'Veuillez entrer des informations valides');
                $app->redirect('login');
            }
        }else{
            $app->flash('error', 'Veuillez remplir tous les champs');
            $app->redirect('login');
        }
    }

    public function getRegister(){
        $v = new RegisterView();
        $v->render();
    }

    public function postRegister(){
        $app = \Slim\Slim::getInstance();
        if (isset($_POST['password']) && isset($_POST['password_confirm']) && isset($_POST['email']) && isset($_POST['lastname']) && isset($_POST['firstname'])) {
            $nom = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
            $prenom = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                if (password_verify(filter_var($_POST['password_confirm'], FILTER_SANITIZE_STRING), $hash)) {
                    \mygiftbox\actions\Authentification::createUser($nom, $prenom, $email, $hash);
                    \mygiftbox\actions\Authentification::authentificate($email, $password_c);
                    $app->redirect($app->urlFor('home'));
                } else {
                    $app->flash('error', 'Les mots de passes ne sont pas identiques');
                    $app->redirect('register');
                }
            } else {
                $app->flash('error', 'Veuillez entrer une adresse email valide');
                $app->redirect('register');
            }
        } else {
            $app->flash('error', 'Veuillez remplir tous les champs');
            $app->redirect('register');
        }
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
                if (User::exists($email)) {
                    $user = User::byMail($email);
                    $newpass = bin2hex(\openssl_random_pseudo_bytes(22));
                    $options = [
                        0 => password_hash($user->password, PASSWORD_BCRYPT),
                        1 => $newpass,
                    ];
                    if ($mailer->sendMail($email, $options, 'forgot_pass')) {
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
        if (isset($user) && $_SESSION['temp']) {
            if (password_verify($user->password, $_GET['hash'])) {
                $user->password = $_SESSION['temp'];
                $user->save();
            }
        }
        $app->redirect($app->urlFor('login'));
    }

}