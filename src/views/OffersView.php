<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class OffersView extends View{

    public function render(){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $error = parent::error();
        $pres = "";
        $offers = Prestation::all();
        
        foreach($offers as $offer) {
            $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
            $pres .= <<<END
            <a href='$urlDetailledOffer' class='offer'>
                <img src='$link/assets/img/prestations/$offer->image'>
                <div class='offer_bottom'>
                    <h2>$offer->titre</h2>
                    <div class='offer_bottom_infos'>
                        <p>$offer->categorie_id</p>
                        <p>$offer->prix €</p>
                    </div>
                </div>
            </a>
END;
        }

        $html = "


            <html>
                $this->header
                <body>
                    <div class='container'>
                        
                        $this->menu
                        $error

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