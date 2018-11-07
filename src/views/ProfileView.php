<?php

namespace mygiftbox\views;

use mygiftbox\models\User;
use mygiftbox\models\Box;

class ProfileView extends View{

    public function render(){
        $link = $this->getLink();
        $app = \Slim\Slim::getInstance();
        $urlSettings = $app->urlFor('profile.settings');
        $urlCreateBox = $app->urlFor('profile.createBox');
        $user  = User::where('id', '=', $_SESSION['id_user'])->first();
        $boxes = Box::where('user_id', '=', $_SESSION['id_user'])->get();

        $pres = '';
        foreach($boxes as $box) {

            $slug = Box::getSlug($box->titre);
            $urlBox = $app->urlFor('profile.box', ['slug' => $slug]);

            $pres .= <<<END
            <a href="$urlBox">
                <div class='boxItem'>
                    <h1 class='label_titreBox'>$box->titre</h1>
                    <p class='label_prixBox'>$box->prix_total</p>
                </div>
            </a>
END;
        }

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
                            $pres
                        </div>
                    </div>
                    $this->footer
                </body>
            </html>
        
        ";

        echo $html;
    }

}