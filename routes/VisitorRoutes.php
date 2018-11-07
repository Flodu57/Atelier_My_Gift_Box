<?php

use mygiftbox\controllers\VisitorController;
use mygiftbox\models\Box;

function CheckOpeningDate($route){

    $box = Box::byToken($route->getParam('token'));
    $date_ouverture = new DateTime($box->date_ouverture);
    $app = \Slim\Slim::getInstance();
    if($date_ouverture > new DateTime('now')){
        $app->redirect($app->urlFor('home'));
    }
}

$app->get('/:token', 'CheckOpeningDate', function($token){
    $c = new VisitorController();
    $c->getBoxVisitor($token);
});