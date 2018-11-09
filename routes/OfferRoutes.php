<?php

use mygiftbox\controllers\OffersController;

$app->get("/offers", function(){
    $c = new OffersController;
    $c->getOffers(0);
})->name('offers');

$app->get("/offers/:category", function($category){
    $c = new OffersController;
    $c->getOffers(0, $category);
})->name('offers.category');

$app->get("/offers/:category/:id", function($category, $id) {
    $c = new OffersController;
    $c->getDetailedOffer($id);
})->name('detailed.offer');

$app->post("/offers/:categorie/:id", function($categorie, $id) {
    $c = new OffersController;
    $c->postAddOfferToBox($id);
});

$app->post("/offers", function() {
    $c = new OffersController;
    $c->getOffers(filter_var($_POST['sort'], FILTER_SANITIZE_NUMBER_INT));
});