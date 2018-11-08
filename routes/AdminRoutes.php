<?php

use mygiftbox\models\Prestation;
use mygiftbox\controllers\AdminController;

$app->get("/delete_offer/:id", function($id){
    $c = new AdminController();
    $c->getDeleteOffer($id);
})->name('deleteOffer');

$app->get("/modify_offer/:id", function($id){
    $c = new AdminController();
    $c->getModifyOffer($id);
})->name('modifyOffer');

$app->get("/lock_offer/:id", function($id){
    $c = new AdminController();
    $c->getLockOffer($id);
})->name('lockOffer');