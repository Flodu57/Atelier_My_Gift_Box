<?php
namespace mygiftbox\controllers;

class Controller{

    protected $urls, $twigParams;

    public function __construct(){
        $app = \Slim\Slim::getInstance();

        $this->urls = [
            'login' => $app->urlFor('login'),
            'forgot' => $app->urlFor('forgotpass'),
            'register'=>  $app->urlFor('register'),
            'logout' => $app->urlFor('logout')
        ];

        if(isset($_SESSION['id_user'])){
            $this->twigParams['user_id'] = $_SESSION['id_user'];
            $this->twigParams['profile'] = $app->urlFor('profile', ['id' => $_SESSION['id_user']]);
        
        }

        if(isset($_SESSION['slim.flash']['success'])){
            $this->twigParams['error'] = $_SESSION['slim.flash']['success'];
        }

        if(isset($_SESSION['slim.flash']['error'])){
            $this->twigParams['error'] = $_SESSION['slim.flash']['error'];
        }
        
        $this->twigParams['urls'] = $this->urls;

    }
}