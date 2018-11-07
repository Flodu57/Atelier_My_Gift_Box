<?php

namespace mygiftbox\views;

use mygiftbox\models\Box;

class OfferDetailledView extends View{

    private $offer;

    public function __construct($offer){
        parent::__construct();
        $this->offer = $offer;
    }

    public function render(){

        $error = parent::error();
        $link = $this->getLink();
        $categorie = $this->offer->categorie()->first();
        $image = $this->offer->image;
        $titre = $this->offer->titre;
        $prix = $this->offer->prix;
        $description = $this->offer->description;

        $boxes = '';

        if(isset($_SESSION['id_user'])){
            $boxes = Box::byUserId($_SESSION['id_user']);
        };

        $pres = '';
        foreach ($boxes as $box) {
            $pres .= <<<END
                <option value='$box->id'>$box->titre</option>
END;
        }

        $html = "


            <html>
                $this->header
                <body>
                    <div class='container'>
                        $this->menu
                       $error
                        <div class='detailled_offer'>  
                            <div class='detailled_offer_top'>  
                                <img src='$link/assets/img/prestations/$image'>
                                <div class='wrap'>
                                    <div class='detailled_offer_top_infos'>
                                        <div class='titles'>
                                            <h2>$titre</h2>
                                            <p>$categorie->titre</p>
                                        </div>
                                        <p class='price'>$prix €</p>
                                    </div>
                                    <form method='POST' class='detailled_offer_top_add'>
                                        <p>Ajouter à la box </p>
                                        <select name='box_id'>
                                            $pres
                                        
                                        </select>
                                        <button class='button button_addOffer' type='submit'>Valider</button>
                                    </form>
                                </div>

                            </div>

                            <div class='detailled_offer_description'> 
                                $description
                            </div>

                        </div>
                        
                        $this->footer

                    </div>
                </body>
            </html>
        
        
        ";

        echo $html;
    }

}