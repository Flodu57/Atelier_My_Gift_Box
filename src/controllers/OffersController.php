<?php

namespace mygiftbox\controllers;

use mygiftbox\views\OffersView;
use mygiftbox\views\OfferView;

class OffersController{

    public function getOffers(){
        $v = new OffersView();
        return $v->render();
    }

    public function getDetailedOffer(){
        $v = new RegisterView();
        return $v->render();
    }

}