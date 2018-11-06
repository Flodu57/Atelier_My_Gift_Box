<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class OffersView extends View{

    public function render(){
        $header = $this->header("Prestations");
        $menu = $this->menu();
        $app = \Slim\Slim::getInstance();
        $link = $app->request()->getUrl() . $app->request()->getRootUri();
        $pres = "";
        $offers = Prestation::all();
        foreach($offers as $k => $v) {
            $pres .= <<<END
            <a href='#' class='offer'>
                <img src='$link/assets/img/prestations/$v->image'>
                <h2>$v->titre</h2>
                <div class='offer_info'>
                    <p>$v->categorie_id</p>
                    <p>$v->prix €</p>
                </div>
            </a>
END;
        }

        $html = "


            <html>
                $header
                <body>
                    <div class='container'>
                        
                        $menu
                        <div class='offers'> 
                           $pres 
                        </div>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}