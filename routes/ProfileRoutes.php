<?php

use mygiftbox\models\User;
use mygiftbox\controllers\ProfileController;

function checkProfile($route){
    $app = \Slim\Slim::getInstance();
    $id  = $route->getParam('id');

    if(!isset($_SESSION['id_user']) || ($_SESSION['id_user'] != $id)){
            $app->flash('error','Vous devez vous identifier');
            $app->redirect($app->urlFor('login'));
    }
    
};

$app->group('/profile','checkProfile', function() use ($app){

    $app->get("/:id", function($id){
        $c = new ProfileController();
        $c->getProfile();
    })->name('profile');
    
    $app->get("/:id/settings", function($id){
        $c = new ProfileController();
        $c->getSettings();
    })->name('profil.settings');
    
    $app->post("/:id/settings", function($id){
        $c = new ProfileController();
        $c->changePassword($id);    
    });
    
    $app->delete("/:id/settings", function($id){
        $c = new ProfileController();
        $c->deleteAccount($id); 
    });
});

