<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferDetailledView;

class OffersController{

    public function getOffers(){
        $v = new OffersView();
        return $v->render();
    }

    public function getDetailledOffer($offer){
        $v = new OfferDetailledView($offer);
        return $v->render();
    }

}