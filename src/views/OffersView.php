<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;
use mygiftbox\models\Categorie;

class OffersView extends View{

    public function render(){
        $link = $this->getLink();
        $error = parent::error();
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

        $cat = "";
        $categories = Categorie::all();
        foreach($categories as $categorie) {
            $cat .= <<<END
            <div>
                <input type='checkbox' id='$categorie->id' name='$categorie->titre' value='$categorie->titre' checked />
                <label for='$categorie->titre'>$categorie->titre</label>
            </div>
END;
        }

        $html = "


            <html>
                $this->header
                <body>
                    <div class='container'>
                        
                        $this->menu
                        $error
                        $cat
                        
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