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
        $titre = $this->box->titre;
        $total = $this->box->prix_total;
        $payment = $this->payment();
        $paymentButton = $this->paymentButton();
        $etat = $this->box->etat;

        $urlOffers = $app->urlFor('offers');

        $pres = "";
        $offers = $this->box->prestations()->get();
        

        $html = <<<END
            <html>
                $this->header
                <body>     
                    
                </body>
            </html>  
END;
        echo $html;
    }

    private function payment(){
        if($this->box->url_cagnotte){
            $total = $this->box->prix_total;
            $amount_cagnotte = $this->box->montant_cagnotte;

            if($this->box->etat== 'fermé'){
                return "La cagnotte est fermée et a totalisé : $amount_cagnotte / $total €";
            }

            return "Cagnotte : $amount_cagnotte / $total €";
        }
        else{
            $p = $this->box->payer ? 'Payé' : 'Non payé';
            return "<p>Payer : $p</p>";
        }
    }
  
    private function paymentButton(){
        $app  = \Slim\Slim::getInstance();

        $urlClose = $app->urlFor('profile.closeCagnotte', ['slug' => $this->box->slug]);
  
        if(!$this->box->url_cagnotte && $this->box->prestations->count() >= 2 )          
            return "<a href='#' class='button button_validateBox'>Passer au paiement</a>";
        else{
            if($this->box->montant_cagnotte >= $this->box->prix_total && $this->box->etat != 'fermé' && $this->box->prestations->count() >= 2)
                return "<a href='$urlClose' class='button button_validateBox'>Fermer la cagnotte</a>";
        }
    }

    private function deleteOffer($offer){
        $app  = \Slim\Slim::getInstance();

        $urlDeleteOffer = $app->urlFor('profile.deleteOffer', ['slug' => $offer->boxes()->first()->slug,'id' => $offer->id]);
        if($this->box->etat != 'fermé'){
            return "<a href='$urlDeleteOffer' class='delete'><p>x</p></a>";
        }
        
    }
}