<?php
use mygiftbox\controllers\UserController;

$app->get("/login", function() use ($app){
    $c = new UserController();
    $c->getLogin();
})->name('login');

$app->post("/login", function() use ($app){
    include 'src/actions/login.php';
})->name('post_login');

$app->post("/register", function() use ($app){
    include 'src/actions/register.php';
})->name('post_register');

$app->get("/register", function() use ($app){
    $c = new UserController();
    $c->getRegister();
})->name('register');

$app->get('/logout', function() use ($app){
    $c = new UserController();
    $c->postLogout();
})->name('logout');