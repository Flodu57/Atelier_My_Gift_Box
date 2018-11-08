<?php

use mygiftbox\controllers\OffersController;
use  mygiftbox\models\Prestation;

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
    $offer = Prestation::byId($id);
    $c->getDetailledOffer($offer);
})->name('offers.detailled');

$app->post("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->postAddOfferToBox($offer);
});

$app->get("/deleteoffer/:id", function($id){
    $c = new OffersController();
    $c->getDeleteOffer($id);
})->name('deleteOffer');

$app->get("/modifyoffer/:id", function($id){
    $c = new OfferController();
    $c->getModifyOffer($id);
})->name('modifyOffer');

$app->get("/lockoffer/:id", function($id){
    $c = new OfferController();
    $c->getLockOffer($id);
})->name('lockOffer');