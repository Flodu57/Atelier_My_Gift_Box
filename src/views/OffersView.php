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
        foreach($offers as $offer) {
            $pres .= <<<END
            <a href='#' class='offer'>
                <img src='$link/assets/img/prestations/$offer->image'>
                <h2>$offer->titre</h2>
                <div class='offer_info'>
                    <p>$offer->categorie_id</p>
                    <p>$offer->prix €</p>
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