<?php

require 'vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DB;
use mygiftbox\controllers\HomeController;

session_start();

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

include 'routes/UserRoutes.php';
include 'routes/ProfileRoutes.php';

$app->run();