<?php

namespace mygiftbox\views;

class View{

    protected $header, $menu, $footer;

    public function __construct(){
        $this->header = $this->header();
        $this->menu = $this->menu();
        $this->footer = $this->footer();
    }

    public function header(){
        $link = $this->getLink();
        return <<<END
            <head>
                <meta charset='utf-8'>
                <link rel='stylesheet' href='$link/assets/css/style.css'>
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
                <title>MyGiftBox</title>
            </head>
END;
    }

    public function getLink(){
        $app = \Slim\Slim::getInstance();
        return $app->request()->getUrl() . $app->request()->getRootUri();
    }

    public function menu(){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $urlHome = $app->urlFor('home');
        $urlOffers = $app->urlFor('offers');
        $html = <<<END
        <div class='menu'>
            <img src='$link/assets/img/logo.png'>
            <a href='$urlHome'>Accueil</a>
            <a href='$urlOffers'>Prestations</a>
END;
        if(isset($_SESSION['id_user'])){
            $urlProfile = $app->urlFor('profile', ['id' => $_SESSION['id_user']]);
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
            return "<div class='errors'><p class='error danger'>".$_SESSION['slim.flash']['error']."</p></div>";
        }

        if(isset($_SESSION['slim.flash']['success'])){
            return "<div class='errors'><p class='error success'>".$_SESSION['slim.flash']['success']."</p></div>";
        }
        return "";
    }
}