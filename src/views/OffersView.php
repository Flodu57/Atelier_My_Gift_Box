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
                $this->header
                <body>
                    <div class='container'>
                        
                        $this->menu
                        <div class='offers'> 
                            <a href='#' class='offer'>
                                <img src='$link/assets/img/diner.jpg'>
                                <h2>Prestations</h2>
                                <div class='offer_info'>
                                    <p>Catégorie</p>
                                    <p>XX €</p>
                                </div>
                            </a>

                           $pres 

                        </div>
                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}