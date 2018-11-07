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
            //$categorie = $offer->categorie()->first();
            $pres .= <<<END
            <a href='#' class='offer'>
                <img src='$link/assets/img/prestations/$offer->image'>
                <div class='offer_bottom'>
                    <h2>$offer->titre</h2>
                    <div class='offer_bottom_infos'>
                        <p></p>
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
                <a href='#'>$categorie->titre</a>
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
                        <div class='tri_categories'>
                            <p>Trier par catégories</p>
                            <i id='slide_arrow' class='fas fa-angle-down'></i>
                            <div id='cat_list' class='categories'>
                                $cat
                            </div>
                        </div>
                        <div class='offers'> 
                           $pres 
                        </div>
                    </div>
                    <script src='$link/assets/scripts/jquery.js'></script>
                    <script src='$link/assets/scripts/offers_sliding_sort.js'></script>
                </body>
            </html>
        
        
        ";

        echo $html;
    }



}