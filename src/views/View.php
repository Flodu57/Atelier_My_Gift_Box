<?php

namespace mygiftbox\views;

class View{

    protected $header, $menu;

    public function __construct(){
        $this->header = $this->header();
        $this->menu = $this->menu();
    }

    public function header(){
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $t = '-1';
        if(isset($_SESSION['id_user'])){
            $t = $_SESSION['id_user'];
        }
        return <<<END
            <head>
                <meta charset='UTF-8'>
                <link rel='stylesheet' href='$link/assets/css/style.css'>
                <title>MyGiftBox - $t </title>
            </head>
END;
    }

    public function menu(){
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $urlHome = $app->urlFor('home');
        $urlOffers = '#';
        $html = <<<END
        <div class='menu'>
            <img src='$link/assets/img/logo.png'>
            <a href='$urlHome'>Accueil</a>
            <a href='$urlOffers'>Prestations</a>
END;
        if(isset($_SESSION['id_user'])){
            $urlProfile = '#';
            $urlLogout = $app->urlFor('logout');
            $html .= <<<END
            <a href='$urlProfile'>Mon compte</a>
            <a href='$urlLogout'>Déconnexion</a>
        </div>
END;
        } else {
            $urlLogin = $app->urlFor('login');
            $urlRegister = $app->urlFor('register');
            $html .= <<<END
            <a href='$urlLogin'>Connexion</a>
            <a href='$urlRegister'>Inscription</a>
        </div>
END;
        }
        return $html;
    }

    public function footer(){
        
        return "
            <footer>
                <p>Conditions Générales de Vente | Politique de confidentialité | Mentions Légales</p>
                <p>© 2018 - CORDIER | ROHRBACHER | RALLI | ZINK</p>
            </footer>
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