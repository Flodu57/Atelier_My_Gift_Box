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
            'logout' => $app->urlFor('logout'),
            'offers' => $app->urlFor('offers')
        ];

        
        
        if(isset($_SESSION['id_user'])){
            $this->urls['profile'] = $app->urlFor('profile', ['id' => $_SESSION['id_user']]);
        }
        
        $this->twigParams = ['urls' => $this->urls];
    }
}