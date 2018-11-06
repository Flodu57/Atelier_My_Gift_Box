<?php

use mygiftbox\controllers\ProfileController;

$app->get("/profile/:id/settings", function($id) use ($app){
    $c = new ProfileController();
    $c->getSettings($id);
})->name('profil.settings');

$app->post("/profile/:id/settings", function($id) use ($app){
    $c = new ProfileController();
    $c->changePassword($id);    
});

$app->delete("/profile/:id/settings", function($id) use ($app){
    $c = new ProfileController();
    $c->deleteAccount($id); 
});
