<?php

use mygiftbox\controllers\AdminController;

$app->get("/delete_offer/:id", function($id){
    $c = new AdminController();
    $c->getDeleteOffer($id);
})->name('deleteOffer');

/*$app->get("/modify_offer/:id", function($id){
    $c = new AdminController();
    $c->getModifyOffer($id);
})->name('modifyOffer');*/

$app->get("/lock_offer/:id", function($id){
    $c = new AdminController();
    $c->getLockOffer($id);
})->name('lockOffer');

$app->get("/create_modify_offer/:id", function($id){
    $c = new AdminController();
    $c->getCreateOrModifyOffer($id);
})->name('createModifyOffer');

$app->post("/create_modify_offer/:id", function($id){
    $c = new AdminController();
    $c->postCreateOrModifyOffer($id);
})->name('createModifyOffer.post');