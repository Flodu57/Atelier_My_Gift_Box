<?php

use mygiftbox\controllers\OffersController;
use  mygiftbox\models\Prestation;

$app->get("/offers", function() use ($app){
    $c = new OffersController;
    $c->getOffers();
})->name('offers');

$app->get("/offers/:categorie/:id", function($categorie, $id) use ($app){
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->getDetailledOffer($offer);
})->name('offers.detailled');

$app->post("/offers/:categorie/:id", function($categorie, $id) use ($app){
    $c = new OffersController;
    $offer = Prestation::byId($id);
    $c->postAddOfferToBox($offer);
});