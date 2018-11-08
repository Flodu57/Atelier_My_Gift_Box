<?php

namespace mygiftbox\controllers;

use mygiftbox\views\HomeView;

class HomeController extends Controller {

    public function getHomePage(){
        $app = \Slim\Slim::getInstance();
        $app->render('HomeView.twig', $this->twigParams);
    }

}