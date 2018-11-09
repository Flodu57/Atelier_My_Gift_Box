<?php

use mygiftbox\models\User;
use mygiftbox\models\Box;
use mygiftbox\controllers\ProfileController;

function checkProfile($route){
    $app = \Slim\Slim::getInstance();

    if(!isset($_SESSION['id_user'])){
            $app->flash('error','Vous devez vous identifier');
            $app->redirect($app->urlFor('login'));
    }
    
};

$app->group('/profile','checkProfile', function() use ($app){

    $app->get("/", function(){
        $c = new ProfileController();
        $c->getProfile();
    })->name('profile');

    $app->get("/createBox", function(){
        $c = new ProfileController();
        $c->getCreateBox();
    })->name('profile.createBox');

    $app->post("/createBox", function(){
        $c = new ProfileController();
        $c->postCreateBox();
    });
    
    $app->get("/settings", function(){
        $c = new ProfileController();
        $c->getSettings();
    })->name('profile.settings');
    
    $app->post("/settings", function(){
        $c = new ProfileController();
        $c->changePassword();    
    });
    
    $app->delete("/settings", function(){
        $c = new ProfileController();
        $c->deleteAccount(); 
    });

    $app->get("/:slug", function($slug){
        $c = new ProfileController();
        $c->getBox($slug);
    })->name('profile.box');

    $app->post("/:slug", function($slug){
        $app = \Slim\Slim::getInstance();

        $box = Box::bySlug($slug);

        if($box){
            $box->paid = 1;
            $box->status = 'closed';
            $box->payment_method = 'stripe';
            $box->save();
        }

        $app->flash('success', 'Votre payement a été fait avec succés !');
        $app->redirect($app->urlFor('profile'));
    });

    $app->get("/:slug/closeCagnotte", function($slug){
        $c = new ProfileController();
        $c->getCloseCagnotte($slug);
    })->name('profile.closeCagnotte');

    $app->get("/deletebox/:slug", function($slug){
        $c = new ProfileController();
        $c->getDeleteBox($slug);
    })->name('profile.deleteBox');

    $app->get("/deleteoffer/:slug/:id", function($slug, $id){
        $c = new ProfileController();
        $c->getDeleteOffer($slug, $id);
    })->name('profile.deleteOffer');
});

