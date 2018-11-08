<?php

use mygiftbox\controllers\OffersController;

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
    $c->getDetailedOffer($id);
})->name('offers.detailed');

$app->post("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->postAddOfferToBox($offer);
});