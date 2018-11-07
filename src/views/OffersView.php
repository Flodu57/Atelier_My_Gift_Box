<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class OffersView extends View{

    public function render(){
        $link = $this->getLink();
        $pres = "";
        $offers = Prestation::all();
        foreach($offers as $offer) {
            $pres .= <<<END
            <a href='#' class='offer'>
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