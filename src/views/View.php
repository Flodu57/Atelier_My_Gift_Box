<?php

namespace mygiftbox\views;

class View{

    public function header(){
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        return "
                <head>
                    <meta charset='UTF-8'>
                    <link rel='stylesheet' href='$link/assets/css/style.css'>
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

    public function error(){
        if(isset($_SESSION['slim.flash']['error'])){
            return "<div class='errors'><p class='p_error'>".$_SESSION['slim.flash']['error']."</p></div>";
        }

        if(isset($_SESSION['slim.flash']['success'])){
            return "<div class='success'><p class='p_success'>".$_SESSION['slim.flash']['success']."</p></div>";
        }

        return "";

    }

}