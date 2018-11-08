<?php

namespace mygiftbox\views;
use mygiftbox\models\Prestation;

class BoxView extends View{


    public function render(){
        $payment = $this->payment();
        $paymentButton = $this->paymentButton();
        $etat = $this->box->etat;

        $urlOffers = $app->urlFor('offers');
    }

    private function deleteOffer($offer){
        $app  = \Slim\Slim::getInstance();

        
        
    }
}