<?php

namespace mygiftbox\views;

use mygiftbox\models\User;

class ProfileView extends View{

    public function render(){
        $link = $this->getLink();
        $app = \Slim\Slim::getInstance();
        $urlSettings = $app->urlFor('profile.settings');
        $urlCreateBox = $app->urlFor('profile.createBox');
        $user = User::where('id', '=', $_SESSION['id_user'])->first();

        $html = "

            <html>
                $this->header
                <body>
                    <div class='container'>
                    ".parent::error()."
                        $this->menu
                        <div class='accountInformations'> 
                            <h1 class='title title_informations'>Mes informations</h1>
                            <div class='accountInformations'>
                                <div class='accountLabel'>
                                    <p class='label label_firstname'>$user->prenom</p>
                                    <p class='label label_lastname'>$user->nom</p>
                                    <p class='label label_mail'>$user->email</p>
                                </div>
                                <div class='accountSettings'>
                                    <img src='$link/assets/img/settings.svg' class='imageSettings'>
                                    <a href='$urlSettings' class='label label_settings'>Paramètres</a>
                                </div>
                            </div>
                        </div>

                        <div class='mybox'>
                            <h1 class='title title_informations'>Mes box</h1>
                            <a href='$urlCreateBox'>
                                <i class='fas fa-plus'></i>
                            </a>
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
                    $this->footer
                </body>
            </html>
        
        ";

        echo $html;
    }

}