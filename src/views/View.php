<?php

namespace mygiftbox\views;

class View{

    public function header($title){

        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        return "
                <head>
                    <meta charset='UTF-8'>
                    <link rel='stylesheet' href='$link/assets/css/style.css'>
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