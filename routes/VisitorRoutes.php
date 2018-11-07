<?php

use mygiftbox\controllers\VisitorController;

$app->get('/:token', function($token){
    $c = new VisitorController();
    $c->getBoxVisitor($token);
});