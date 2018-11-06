<?php

namespace mygiftbox\views;

class View{

    public function header(){
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        return "
                <head>
                    <meta charset='UTF-8'>
                    <link rel='stylesheet' href='$link/assets/css/index.css'>
                    <title>MyGiftBox</title>
                </head>
            ";
    }

    public function menu(){
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $urlHome = $app->urlFor('home');
        $urlOffers = '#';
        $urlProfile = '#';
        $urlLogout = $app->urlFor('logout');
        return "
            <div class='menu'>
                <img src='$link/assets/img/logo.png'>
                <a href='$urlHome'>Accueil</a>
                <a href='$urlOffers'>Prestations</a>
                <a href='$urlProfile'>Mon compte</a>
                <a href='$urlLogout'>Déconnexion</a>
            </div>
        ";    
    }

}