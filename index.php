<?php

require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use mygiftbox\controllers\UserController;
use mygiftbox\controllers\HomeController;

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/config.ini'));
$db->setAsGlobal();
$db->bootEloquent();


$app = new \Slim\Slim();

$app->get("/", function() use ($app){
    $app->redirect('home');
})->name('root');

$app->get("/home", function() use ($app){
    $c = new HomeController();
    $c->getHomePage();
})->name('home');

$app->get("/login", function() use ($app){
    $c = new UserController();
    $c->getLogin();
})->name('login');

$app->get("/register", function() use ($app){
    $c = new UserController();
    $c->getRegister();
})->name('register');

$app->get('/logout', function() use ($app){
    $c = new UserController();
    $c->postLogout();
})->name('logout');

$app->run();