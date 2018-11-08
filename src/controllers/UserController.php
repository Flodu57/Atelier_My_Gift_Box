<?php

namespace mygiftbox\controllers;

use mygiftbox\mailer\ServerMailer;
use mygiftbox\models\User;
use mygiftbox\views\ForgotPasswordView;
use mygiftbox\views\LoginView;
use mygiftbox\views\RegisterView;

class UserController extends Controller{

    public function getLogin(){
        $app = \Slim\Slim::getInstance();
        
        if(isset($_SESSION['slim.flash']['error'])){
            $this->twigParams['error'] = $_SESSION['slim.flash']['error'];
        }

        if(isset($_SESSION['slim.flash']['success'])){
            $this->twigParams['error'] = $_SESSION['slim.flash']['success'];
        }

        if(isset($_SESSION['id_user'])){
            $this->twigParams['user_id'] = $_SESSION['id_user'];
        }   
        
        $app->render('LoginView.twig', $this->twigParams);
    }

    public function postLogin(){
        $app = \Slim\Slim::getInstance();
        if(isset($_POST['email']) && isset($_POST['password'])){
            $mail = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
            if(!empty($mail) && !empty($password)){
                $user = User::byMail($mail);
                //if($user && $user->account_level > 0){
                    if(password_verify($password, $user->password)){
                        $_SESSION['id_user'] = $user->id;
                        $app->redirect('home');
                    }else{
                        $app->flash('error', 'Mot de passe ou utilisateur incorrect');
                        $app->redirect('login');
                    }
                /*}else{
                    $app->flash('error', 'Votre compte ne rempli pas les conditions requises');
                    $app->redirect('login');
                }*/
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
                $hash = password_hash($password, PASSWORD_BCRYPT);
                if (password_verify(filter_var($_POST['password_confirm'], FILTER_SANITIZE_STRING), $hash)) {
                    if(!User::exists($email)){
                        $mailer = new ServerMailer($app);
                        $options = [0 => password_hash($hash, PASSWORD_BCRYPT)];
                        if($mailer->sendMail($email, $options, 'register')){
                            User::addNew($email, $hash, $nom, $prenom);
                            $app->flash('success', "Vous vous êtes inscrit avec succès. Veuillez consulter vôtre boîte mail pour valider vôtre compte");
                            $app->redirect($app->urlFor('login'));
                        } else {
                            $app->flash('error',"L'adresse email fournie est invalide");
                            $app->redirect('register');
                        }
                    }else{
                        $app->flash('error', "L'utilisateur existe déjà");
                        $app->redirect('register');
                    }
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

    public function getRegisterMailCheck(){
        $app = \Slim\Slim::getInstance();
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
        $user = User::byMail($email);
        if ($user && $user->account_level == 0) {
            if (password_verify($user->password, $_GET['hash'])) {
                $user->account_level = 1;
                $user->save();
                session_destroy();
                session_start();
                $_SESSION['id_user'] = $user->id;
                $app->redirect('home');
            } else {
                $app->flash('error', 'Le lien que vous avez suivi est incorrect');
                $app->redirect('register');
            }
        } else {
            $app->flash('error', 'Le lien que vous avez suivi est expiré');
            $app->redirect('register');
        }
    }

    public function getLogout(){
        $app = \Slim\Slim::getInstance();
        session_destroy();
        $app->redirect('home');
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
        $app->redirect('forgotpass');
    }

    public function getForgotLinkClicked(){
        $app = \Slim\Slim::getInstance();
        $email = filter_var($_GET['email'], FILTER_SANITIZE_EMAIL);
        $user = User::byMail($email);
        if (isset($user) && $_SESSION['temp']) {
            if (password_verify($user->password, $_GET['hash'])) {
                $user->password = $_SESSION['temp'];
                $user->save();
            }
        }
        $app->redirect('login');
    }

}