<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;
use mygiftbox\models\Categorie;

class OffersView extends View{

    public function render(){
        $app = \Slim\Slim::getInstance();
        $link = $this->getLink();
        $error = parent::error();
        $pres = "";
        $offers = Prestation::all();
        
        foreach($offers as $offer) {
            $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
            $categorie = $offer->categorie->titre;
            $pres .= <<<END
            <a href='$urlDetailledOffer' class='offer'>
                <img src='$link/assets/img/prestations/$offer->image'>
                <div class='offer_bottom'>
                    <h2>$offer->titre</h2>
                    <div class='offer_bottom_infos'>
                        <p>$categorie</p>
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