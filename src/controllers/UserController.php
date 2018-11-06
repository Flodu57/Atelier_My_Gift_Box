<?php

namespace mygiftbox\controllers;

use mygiftbox\views\LoginView;
use mygiftbox\views\RegisterView;

class UserController{

    public function getLogin(){
        $v = new LoginView();
        $v->render();
    }

    public function getRegister(){
        $v = new RegisterView();
        $v->render();
    }

    public function postLogout(){
        $app = \Slim\Slim::getInstance();
        session_destroy();
        $app->redirect($app->urlFor('home'));
    }

}