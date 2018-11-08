<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class BoxView extends View{

    private $box;

    public function __construct($box){
        parent::__construct();
        $this->box = $box;
    }

    public function render(){
        $link = $this->getLink();
        $error = parent::error();
        $titre = $this->box->titre;
        $total = $this->box->prix_total;
        $payer = $this->box->payer ? 'Payé' : 'Non payé';
        $etat = $this->box->etat;
        $error = parent::error();
        $validateButton = $this->validateButton();

        $app = \Slim\Slim::getInstance();

        $urlOffers = $app->urlFor('offers');

        $pres = "";
        $offers = $this->box->prestations()->get();
        foreach($offers as $offer) {
            $urlDetailledOffer = $app->urlFor('offers.detailled', ['categorie' => $offer->categorie->titre, 'id' => $offer->id]);
            $urlDeleteOffer = $app->urlFor('profile.deleteOffer', ['slug' => $offer->boxes()->first()->slug,'id' => $offer->id]);

            $pres .= <<<END
            <div class='containerBox'>
                <a href='$urlDetailledOffer' class='offer'>
                    <img src='$link/assets/img/prestations/$offer->image'>
                    <div class='offer_bottom'>
                        <h2 class='label label_title'>$offer->titre</h2>
                        <div class='offer_bottom_infos'>
                            <p class='label label_category'>$offer->categorie_id</p>
                            <p class='label label_price'>$offer->prix €</p>
                        </div>
                    </div>
                </a>
                <a href="$urlDeleteOffer" class='delete'>
                    <p>x</p>
                </a>
            </div>
END;
        }

        $html = <<<END
            <html>
                $this->header
                <body>     
                    <div class='container'>
                        $this->menu
                        <div class='box'>
                            <div class='box_head'>
                                <div>
                                    <h2>$titre</h2>
                                    <p>Etat : $etat</p>
                                    <p>Payer : $payer</p>
                                </div>
                                <div class='box_head_total'>
                                    <p class='p_total'>Total </p>
                                    $total
                                    <p>€</p>
                                </div>
                            </div>  
                            $error

                            <div class='box_grid'>
                                $pres 
                            </div>
                            <div class='buttonLayout buttonLayout-center'>
                                <a href='$urlOffers' class='button button_continueBox'>Continuer les achats</a>
                                $validateButton
                            </div>
                        </div>
                        $this->footer
                    </div>
                </body>
            </html>  
END;
        echo $html;
    }

    private function validateButton(){
        if($this->box->prestations->count()>=2){
            return "<a href='#' class='button button_validateBox'>Passer au paiement</a>";
        }
    }
}