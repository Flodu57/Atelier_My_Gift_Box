<?php

namespace mygiftbox\views;

class View{

    public function header($title){

        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        return "
                <head>
                    <meta charset='UTF-8'>
                    <link rel='stylesheet' href='$link/assets/css/index.css'>
                    <title>$title - MyGiftBox</title>
                </head>

                  ";
    }

    public function menu(){

        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        return "
            <div class='menu'>
                <img src='$link/assets/img/logo.png'>
                <a href='index.html'>Accueil</a>
                <a href='prestations.html'>Prestations</a>
                <a href='account.html'>Mon compte</a>
            </div>

        ";
        

        
    }

}