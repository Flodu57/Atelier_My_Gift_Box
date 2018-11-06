<?php

namespace mygiftbox\views;

class ProfileView extends View{

    private $id;

    function __construct($id){
        $this->id = $id;
    }

    public function render(){
        $header = $this->header();
        $menu = $this->menu();
        $link = $this->getLink();
        $app = \Slim\Slim::getInstance();
        $urlSettings = $app->urlFor('profil.settings', ['id' => $this->id]);
        $footer = $this->footer();

        $html = "

            <html>
                $header
                <body>
                    <div class='container'>
                    ".parent::error()."
                        $menu
                        <div class='accountInformations'> 
                            <h1 class='title title_informations'>Mes informations</h1>
                            <div class='accountInformations'>
                                <div class='accountLabel'>
                                    <p class='label label_firstname'>Prénom</p>
                                    <p class='label label_lastname'>Nom</p>
                                    <p class='label label_mail'>Mail</p>
                                </div>
                                <div class='accountSettings'>
                                    <img src='$link/assets/img/settings.svg' class='imageSettings'>
                                    <a href='$urlSettings' class='label label_settings'>Paramètres</a>
                                </div>
                            </div>
                        </div>

                        <div class='mybox'>
                            <h1 class='title title_informations'>Mes box</h1>
                            <img src='$link/assets/img/plus.svg' class='imageMybox'>
                        </div>
                        <div class='gridBox'>
                            <div class='boxItem'>
                                <h1 class='label_titreBox'>Titre box</h1>
                                <p class='label_prixBox'>prix</p>
                        </div>
                        <div class='boxItem'>
                            <h1 class='label_titreBox'>Titre box</h1>
                            <p class='label_prixBox'>prix</p>
                        </div>
                        <div class='boxItem'>
                            <h1 class='label_titreBox'>Titre box</h1>
                            <p class='label_prixBox'>prix</p>
                        </div>
                        <div class='boxItem'>
                            <h1 class='label_titreBox'>Titre box</h1>
                            <p class='label_prixBox'>prix</p>
                        </div>
                        <div class='boxItem'>
                            <h1 class='label_titreBox'>Titre box</h1>
                            <p class='label_prixBox'>prix</p>
                        </div>
                    </div>
                    $footer
                </body>
            </html>
        
        ";

        echo $html;
    }

}