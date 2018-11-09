<?php

use mygiftbox\controllers\OffersController;

$app->get("/offers", function(){
    $c = new OffersController;
    $c->getOffers();
})->name('offers');

$app->get("/offers/:category", function($category){
    $c = new OffersController;
    $c->getOffers($category);
})->name('offers.category');

$app->get("/offers/:category/:id", function($category, $id) {
    $c = new OffersController;
    $c->getDetailedOffer($id);
})->name('detailed.offer');

$app->post("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->postAddOfferToBox($offer);
});