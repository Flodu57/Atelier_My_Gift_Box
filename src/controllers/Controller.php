<?php
namespace mygiftbox\controllers;

use mygiftbox\models\User;

class Controller{

    protected $urls, $twigParams;

    public function __construct(){
        $app = \Slim\Slim::getInstance();
        $this->urls = [
            'login' => $app->urlFor('login'),
            'forgot' => $app->urlFor('forgotpass'),
            'register'=>  $app->urlFor('register'),
            'logout' => $app->urlFor('logout'),
            'offers' => $app->urlFor('offers'),
            'settings' => $app->urlFor('profile.settings'),
            'createBox' => $app->urlFor('profile.createBox'),
            'box' => $app->urlFor('profile.box', compact('slug')),
            'home' => $app->urlFor('home'),
            'offer' => $app->urlFor('detailed.offer'),
            'createOffer' => $app->urlFor('createModifyOffer', ['id' => 0])
        ];
        $this->twigParams['urls'] = $this->urls;
        if(isset($_SESSION['id_user'])){
            $this->twigParams['user_level'] = User::byId($_SESSION['id_user'])->account_level;
            $this->twigParams['user_id'] = $_SESSION['id_user'];
            $this->twigParams['urls']['profile'] = $app->urlFor('profile');
        } else {
            $this->twigParams['user_level'] = 0;
        }
        if(isset($_SESSION['slim.flash']['success'])){
            $this->twigParams['error'] = ['message' => $_SESSION['slim.flash']['success'], 'type' => array_keys($_SESSION['slim.flash'])[0]];
        }
        if(isset($_SESSION['slim.flash']['error'])){
            $this->twigParams['error'] = ['message' => $_SESSION['slim.flash']['error'], 'type' => array_keys($_SESSION['slim.flash'])[0]];
        }   
    }

    public function getRoute($name, $param){
        $app = \Slim\Slim::getInstance();
        return $app->urlFor($name, $param);
    }
}