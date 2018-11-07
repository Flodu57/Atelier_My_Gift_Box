<?php

use mygiftbox\controllers\VisitorController;
use mygiftbox\models\Box;

function CheckOpeningDate($route){
    $token = $route->getParam('token');
    $box = Box::byToken($token);
    $date_ouverture = new DateTime($box->date_ouverture);
    $app = \Slim\Slim::getInstance();
    if($date_ouverture > new DateTime('now')){
        $app->redirect($app->urlFor('visitor.wait', compact('token')));
    }
}

$app->get('/:token', 'CheckOpeningDate', function($token){
    $c = new VisitorController();
    $c->getBoxVisitor($token);
})->name('visitor.token');

$app->get('/wait/:token', function($token){
    $c = new VisitorController();
    $c->getWait($token);
})->name('visitor.wait');