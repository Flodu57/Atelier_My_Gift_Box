<?php

use mygiftbox\controllers\OffersController;
use  mygiftbox\models\Prestation;
use  mygiftbox\models\Offer;


$app->get("/offers", function(){
    $c = new OffersController;
    $c->getOffers();
})->name('offers');

$app->get("/offers/:category", function($category){
    $c = new OffersController;
    $c->getOffersByCategory($category);
})->name('offers.category');

$app->get("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $offer = Offer::byId($id);
    $c->getDetailedOffer($offer);
})->name('detailed.offer');

$app->post("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->postAddOfferToBox($offer);
});