<?php

require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;


$db = new DB();
$db->addConnection(parse_ini_file('src/conf/config.ini'));
$db->setAsGlobal();
$db->bootEloquent();


$app = new \Slim\Slim();

$app->get("/", function() use ($app){
    $app->redirect('home');
})->name('root');

$app->get("/home", function() use ($app){
    echo 'hello world';
})->name('home');

$app->get("/login", function() use ($app){
    $c = new mygiftbox\controllers\UserController;
    $c->getLogin();
})->name('login');

$app->get("/register", function() use ($app){
    $c = new mygiftbox\controllers\UserController;
    $c->getRegister();
})->name('register');

$app->get("/offers", function() use ($app){
    $c = new mygiftbox\controllers\OffersController;
    $c->getOffers();
})->name('offers');

$app->run();