<?php

use mygiftbox\controllers\VisitorController;
use mygiftbox\models\Box;

function CheckOpeningDate($route){
    $app = \Slim\Slim::getInstance();
    $token = $route->getParam('token');
    $box = Box::byToken($token);
    
    if(!$box)
        $app->redirect($app->urlFor('home'));
    
    $opening_date = new DateTime($box->opening_date);
    if($opening_date > new DateTime('now')){
        $app->redirect($app->urlFor('visitor.wait', compact('token')));
    }
}

$app->get('/:token', function($token){
    $c = new VisitorController();
    $c->getBoxVisitor($token);
})->name('visitor.token');

$app->post('/:token', function($token){
    $c = new VisitorController();
    $c->postThanks($token);
});

$app->get('/:token_funding/funding', function($token_funding){
    $c = new VisitorController();
    $c->getFunding($token_funding);
})->name('visitor.funding');

$app->post('/:token_funding/funding', function($token_funding){
    $c = new VisitorController();
    $c->postFunding($token_funding);
});

$app->get('/wait/:token', function($token){
    $c = new VisitorController();
    $c->getWait($token);
})->name('visitor.wait');