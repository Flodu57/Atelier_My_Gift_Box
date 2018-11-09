<?php

use mygiftbox\controllers\VisitorController;
use mygiftbox\models\Box;

function CheckOpeningDate($route){
    $app = \Slim\Slim::getInstance();
    $token = $route->getParam('token');
    $box = Box::byToken($token);
    
    if(!$box)
        $app->redirect($app->urlFor('home'));
    
    $date_ouverture = new DateTime($box->date_ouverture);
    if($date_ouverture > new DateTime('now')){
        $app->redirect($app->urlFor('visitor.wait', compact('token')));
    }
}

$app->get('/:token', 'CheckOpeningDate', function($token){
    $c = new VisitorController();
    $c->getBoxVisitor($token);
})->name('visitor.token');

$app->get('/:token_funding/cagnotte', function($token_funding){
    $c = new VisitorController();
    $c->getFunding($token_funding);
})->name('visitor.funding');

$app->post('/:token_funding/cagnotte', function($token_funding){
    $c = new VisitorController();
    $c->postFunding($token_funding);
});

$app->get('/wait/:token', function($token){
    $c = new VisitorController();
    $c->getWait($token);
})->name('visitor.wait');